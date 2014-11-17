<?php
/**
* Odczytanie danych statusu - lista statusów.
*
* @author  m@sote.pl
* @version $Id: order_status_row.inc.php,v 2.5 2004/12/20 17:58:52 maroslaw Exp $
* @package    order
* @subpackage status
*/

/**
* Klasa pomocnicza
*
* @package order
* @subpackage status
* @ignore
*/
class Rec {
    var $data=array();
}

/**
* Klasa zawieraj±ca funkcjê prezentacji statusu transakcji na li¶cie.
* @package order
* @subpackage status
*/
class Order_StatusRow {
    
    /**
    * Odczytanie danych i wy¶wietlenie statusu transakcji na li¶cie.
    *
    * @param mixed $result wynik zapytania z bazy danych
    * @param int   $i      numer wiersza wyniku zapytania SQL
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;

        $rec = new Rec;

        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");
        $rec->data['send_mail']=$db->FetchResult($result,$i,"send_mail");
    
        include ("./html/row.html.php");
        
        return;
    } // end record()
} // end class DeliveryRow
?>
