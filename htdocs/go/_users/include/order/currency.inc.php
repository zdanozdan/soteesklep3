<?php
/**
* @version    $Id: currency.inc.php,v 1.2 2004/12/20 18:01:56 maroslaw Exp $
* @package    users
*/
class Currency {
    /**
     * Element select z dostepnymi walutami
     */
    function select_list() {
        global $db;
        $query="SELECT * FROM currency";
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {            
                print "<select name=item[id_currency]>\n";
                for ($i=0;$i<$num_rows;$i++) {
                    $id=$db->FetchResult($result,$i,"id"); 
                    $currency_name=$db->FetchResult($result,$i,"currency_name");                
                    print "<option value='$id'>$currency_name\n";                  
                }
                print "</select>\n";
            } else {
                die ("Brak walut w bazie");
            }
        } else {
            die ($db->Error());
        }
        return;
    }
}

$currency = new Currency;
?>
