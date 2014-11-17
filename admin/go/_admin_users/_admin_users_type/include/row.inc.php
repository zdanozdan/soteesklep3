<?php
/**
* Klasa prezentacji wiersza rekordu z tabeli admin_users_type
*
* @author m@sote.pl
* @version $Id: row.inc.php,v 2.3 2004/12/20 17:57:48 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

/**
* @package admin_users
* @ignore
*/
class Rec {
    var $data=array();
}

/**
* Klasa prezentacji rekordu na li¶cie wyników.
* @package admin_users
*/
class ModTableRow {
    
    /**
    * Funkcja generuj±ca rekord na li¶cie.
    *
    * @param mixed $result wynik zapytania z bazy danych
    * @param int   $i      numer wiersza wyniku zapytania z bazy danych
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;
        
        $rec = new Rec;
                
        // config
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['type']=$db->FetchResult($result,$i,"type");
        $rec->data['p_all']=$db->FetchResult($result,$i,"p_all");
        // end

        /**
        * Wsy¶wietl wiersz.
        */
        include ("./html/row.html.php");
        
        return;
    } // end record()
    
} // end class Row
?>
