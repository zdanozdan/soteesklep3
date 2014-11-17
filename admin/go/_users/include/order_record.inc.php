<?php
/**
 * Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
 * Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
* @version    $Id: order_record.inc.php,v 2.2 2004/12/20 17:59:16 maroslaw Exp $
* @package    users
 */ 

class OrderRecordRow {
    var $type="long";                          // rodzaj prezentacji rekordu -  pelny lub skocony

    function record($result,$i) {
        global $db;
        global $theme;
        global $rec;
        
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['order_id']=$db->FetchResult($result,$i,"order_id");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['amount']=$db->FetchResult($result,$i,"amount");
        $rec->data['confirm']=$db->FetchResult($result,$i,"confirm");
        $rec->data['id_pay_method']=$db->FetchResult($result,$i,"id_pay_method");
        $rec->data['id_status']=$db->FetchResult($result,$i,"id_status");

        $theme->order_record_row($rec);

        return;
    }
}
