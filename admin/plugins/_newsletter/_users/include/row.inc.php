<?php
/**
* Definicja klasy i funkcji obs³ugi rekordu prezentacji na li¶cie adresów e-mail.
* 
* @author  rdiak@sote.pl
* @version $Id: row.inc.php,v 2.6 2004/12/20 18:00:20 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

/**
* Klasa pomocnicza.
*
* @package newsletter
* @subpackage users
*/
class Rec {
    var $data=array();
}

/**
* Klasa zawieraj±ca prezentacjê rekordu.
*
* @package newsletter
* @subpackage users
* 
*/
class ModTableRow {
    
    /**
    * Wy¶wietl rekord z nazw± grupy adresów e-mail.
    *
    * @param mixed $result wynika zapytania z bazy danych
    * @param int   $i      numer wiersza wyniku zapytania
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;
        
        require_once ("include/date.inc");
        $my_date = new MyDate;
        
        $rec = new Rec;
        
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['email']=$db->FetchResult($result,$i,"email");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['date_remove']=$db->FetchResult($result,$i,"date_remove");
        $rec->data['status']=$db->FetchResult($result,$i,"status");
        $rec->data['active']=$db->FetchResult($result,$i,"active");
        $rec->data['groups']=$db->FetchResult($result,$i,"groups");
        $rec->data['lang']=$db->FetchResult($result,$i,"lang");
        
        $theme->newsletter_users_row($rec);
        // end
        
        
        return;
    } // end record()
    
} // end class ModTableRow
?>
