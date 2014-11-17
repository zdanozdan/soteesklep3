<?php
/**
* Obsluga kodow do zamowienia (main_keys)
*
* @author  m@sote.pl
* @version $Id: main_keys.inc.php,v 2.2 2004/12/20 17:58:55 maroslaw Exp $
* @package    order
*/

global $__secure_test;
if (@$__secure_test!=true) die ("Frobidden");

/**
* Dodaj obs³uge kodowania (klsasa MyCrypt).
*/
require_once ("include/my_crypt.inc");

/**
* Klasa prezentacji kodów do zamówienia.
* @package order
* @subpackage main_keys
*/
class MainKeys {
    
    /**
    * Pokaz kody do zamowienia
    *
    * @param int $order_id id zamowienia
    * @return none
    */
    function show($order_id) {
        global $db;
        
        if (! ereg("^[0-9]+$",$order_id)) die ("Forbidden order_id");
        
        $query="SELECT * FROM main_keys WHERE order_id=? ORDER BY id";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    print "<table>\n";
                    for ($i=0;$i<$num_rows;$i++) {
                        $this->row($result,$i);
                    } // end for
                    print "</table>\n";
                }
            } else die ($db->Error());
        } else die ($db->Error());
        
        return(0);
    } // end show()
    
    /**
    * Przedstaw kod do zamowienia
    *
    * @param array $result wynik zapytania SQL
    * @param int   $i      numr wiersza wyniku zapytania
    * @return none
    */
    function row(&$result,$i) {
        global $db;
        
        $id=$db->FetchResult($result,$i,"id");
        $order_id=$db->FetchResult($result,$i,"order_id");
        $user_id=$db->FetchResult($result,$i,"user_id_main");
        $crypt_main_key=$db->FetchResult($result,$i,"main_key");
        
        $my_crypt = new MyCrypt;
        $main_key=$my_crypt->endecrypt("",$crypt_main_key,"de");
        
        print "<tr><td>ID[$user_id]</td><td>$main_key</td></tr>\n";
        
        return(0);
    } // end row
    
    /**
    * Pokaz dodatkowe komuniakty "bledy" zwiazane z realizacja zamowienia
    *
    * @param string $status status main_keys_status z oprder_register dla danej transakcji
    * @return none
    */
    function show_errors($status) {
        global $lang;
        
        switch ($status) {
            case "050": print "<font color=red>".$lang->order_main_keys_status[$status]."</font>\n";
            break;
            default: print "<font color=green>".$lang->order_main_keys_status[$status]."</font>\n";;
            break;
        }
        
        return(0);
    } // end show_errors()
    
} // end class

?>
