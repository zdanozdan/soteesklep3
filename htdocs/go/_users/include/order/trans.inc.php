<?php
/**
 * Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
 * Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
* @version    $Id: trans.inc.php,v 1.4 2005/12/12 09:58:01 lukasz Exp $
* @package    users
 */ 

class TransRecordRow {
    var $type="long";                          // rodzaj prezentacji rekordu -  pelny lub skocony
    
    function record($result,$i) {
        global $db;
        global $theme;
        global $rec;
        global $mdbd;
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['order_id']=$db->FetchResult($result,$i,"order_id");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['amount']=$db->FetchResult($result,$i,"amount");
        $rec->data['delivery_cost']=$db->FetchResult($result,$i,"delivery_cost");
        $rec->data['total_amount']=$db->FetchResult($result,$i,"total_amount")+$rec->data['delivery_cost'];
        $rec->data['confirm']=$db->FetchResult($result,$i,"confirm");
        $rec->data['confirm_online']=$db->FetchResult($result,$i,"confirm_online");
        $rec->data['id_pay_method']=$db->FetchResult($result,$i,"id_pay_method");
        $rec->data['id_status']=$db->FetchResult($result,$i,"id_status");
        $rec->data['points_value']=$mdbd->select('points','users_points_history','order_id=?',array($rec->data['order_id']=>"int"),'LIMIT 1');
        $rec->data['points']=$db->FetchResult($result,$i,"points");
                
        $theme->trans_record_row($rec);
        
        return;
    } // end record()

} // end class TransRecordRow
?>
