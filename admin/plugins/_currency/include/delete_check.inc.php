<?php
/**
* Klasa spraedzaj±ca, czy mo¿na usun±æ dany rekord z tabeli currency.
* 
* @author  m@sote.pl
* @version $Id: delete_check.inc.php,v 2.1 2005/04/01 08:36:13 maroslaw Exp $
* @package currency
*/

/**
* Usuwanie walut z tabeli currency.
* @package currency
*/
class Currency_Delete_Check {
    
    // {{{ deleteCheck()
    
    /**
    * Sprawd¼ czy mo¿na usun±æ walutê o wskazanym ID
    * Uwaga! Nazwa funkcji jest zdefiniowana w admin/include/delete.inc.php
    *     
    * @param int    $id     id waluty
    */
    function deleteCheck($id) {
        global $mdbd,$lang;
                       
        $id=intval($id);        
        $dat=$mdbd->select("id","main","id_currency=?",array($id=>"int"),"LIMIT 1");
        
        if ($dat>0) {
            print $lang->currency_delete_error."$id<br>";
            return false;
        } else {
        
            return true;
        }
    } // end deleteCheck()
    
    // }}}
    
} // end class CurrencyDeleteCheck

?>