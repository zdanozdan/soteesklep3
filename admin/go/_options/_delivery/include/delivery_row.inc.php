<?php

class Rec {
    var $data=array();
}

class DeliveryRow {
    function record($result,$i) {
        global $db;
        global $theme;

        $rec = new Rec;
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['name']=$db->FetchResult($result,$i,"name");
        $rec->data['order_by']=$db->FetchResult($result,$i,"order_by");
        $rec->data['price_brutto']=$db->FetchResult($result,$i,"price_brutto");
        $rec->data['free_from']=$db->FetchResult($result,$i,"free_from");
        $rec->data['delivery_info']=$db->FetchResult($result,$i,"delivery_info");
        $rec->data['delivery_pay']=$db->FetchResult($result,$i,"delivery_pay");
        include ("./html/delivery_row.html.php");
        
        return;
    } // end record()
} // end class DeliveryRow
?>