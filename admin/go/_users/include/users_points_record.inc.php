<?php
/**
* Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
* Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
*
* @author  m@sote.pl
* @version $Id: users_points_record.inc.php,v 2.1 2005/10/20 06:31:58 krzys Exp $
* @package    users
*/

/**
* Klasa z funkcj± prezentacji rekordu na li¶cie.
* @package users
* @subpackage admin
*/
class UsersPointsRecordRow {    
       
    var $type="long";                          // rodzaj prezentacji rekordu -  pelny lub skocony
    
    function record($result,$i) {
        global $db;
        global $theme;
        global $rec;
        
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['id_user_points']=$db->FetchResult($result,$i,"id_user_points");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['points']=$db->FetchResult($result,$i,"points");
        $rec->data['description']=$db->FetchResult($result,$i,"description");
        $rec->data['type']=$db->FetchResult($result,$i,"type");
        $rec->data['order_id']=$db->FetchResult($result,$i,"order_id");
        $rec->data['user_id_main']=$db->FetchResult($result,$i,"user_id_main");
                
        
        /**
        * Wy¶wietl wiersz z danymi u¿ytkwonika imiê, nazwisko, email.
        */
        include ("./html/users_points_record_row.html.php");
        
        return;
    } // end record()
    
} // end class UsersRecordRow
