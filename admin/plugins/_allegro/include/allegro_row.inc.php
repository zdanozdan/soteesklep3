<?php

class Rec {
    var $data=array();
}

class AllegroRow {
    function record($result,$i) {
        global $db;
        global $theme;

        $rec = new Rec;
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
        $rec->data['allegro_product_name']=$db->FetchResult($result,$i,"allegro_product_name");
        $rec->data['allegro_price_start']=$db->FetchResult($result,$i,"allegro_price_start");
        $rec->data['allegro_number']=$db->FetchResult($result,$i,"allegro_number");
        $rec->data['allegro_send']=$db->FetchResult($result,$i,"allegro_send");
        include ("./html/allegro_row.html.php");
        
        return;
    } // end record()
} // end class DeliveryRow
?>