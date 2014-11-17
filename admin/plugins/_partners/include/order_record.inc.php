<?php
/**
 * Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
 * Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
* @version    $Id: order_record.inc.php,v 1.5 2004/12/20 18:00:26 maroslaw Exp $
* @package    partners
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
        $rec->data['send_date']=$db->FetchResult($result,$i,"send_date");
        $rec->data['send_number']=$db->FetchResult($result,$i,"send_number");
        $rec->data['id_user']=$db->FetchResult($result,$i,"id_user");
        $rec->data['partner_id']=$db->FetchResult($result,$i,"partner_id");
        $rec->data['rake_off_amount']=$db->FetchResult($result,$i,"rake_off_amount");
        $rec->data['partner_name']=$db->FetchResult($result,$i,"partner_name");
        $rec->data['confirm_online']=$db->FetchResult($result,$i,"confirm_online");

        $theme->order_record_row($rec);

        return;
    }
}
