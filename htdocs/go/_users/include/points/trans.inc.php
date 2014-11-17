<?php
/**
 * Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
 * Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
* @version    $Id: trans.inc.php,v 1.1 2005/10/24 13:34:19 krzys Exp $
* @package    users
 */ 

class TransRecordRow {
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
                
        $theme->points_record_row($rec);
        
        return;
    } // end record()

} // end class TransRecordRow
?>
