<?php
/**
* Definicja klasy i funkcji obs³ugi rekordu prezentacji na li¶cie grup adresów e-mail
*
* @author  rdiak@sote.pl
* @version $Id: row.inc.php,v 2.5 2004/12/20 18:00:15 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

/**
* @package newsletter
* @subpackage groups
* @ignore
*/
class Rec {
    var $data=array();
}

/**
* Klasa zawieraj±ca prezentacjê rekordu.
*
* @package newsletter
* @subpackage groups
* @ignore
*/
class ModTableRow {
    
    /**
    * Wy¶wietl rekord.
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
        $rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");
        $rec->data['count']=$db->FetchResult($result,$i,"count");
        
        $theme->newsletter_groups_row($rec);
        // end
        
        
        return;
    } // end record()
    
} // end class Row
?>
