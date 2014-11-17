<?php
/**
* Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
*
* @author  m@sote.pl
* @version $Id: query_rec_allegro.inc.php,v 2.3 2006/06/28 08:57:16 lukasz Exp $
*
* @global object $result           wynik zapytania SQL o wlasciwosci produktu

* @package    edit
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Forbidden");
}

class RecordData {
    var $data=array();
}

global $rec;
$rec =& new RecordData;

$i=0;

$rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
$rec->data['allegro_auction_type']=$db->FetchResult($result,$i,"allegro_auction_type");
$rec->data['allegro_product_name']=$db->FetchResult($result,$i,"allegro_product_name");
$rec->data['allegro_product_description']=$db->FetchResult($result,$i,"allegro_product_description");
$rec->data['allegro_photo']=$db->FetchResult($result,$i,"allegro_photo");
$rec->data['allegro_miniature']=$db->FetchResult($result,$i,"allegro_miniature");
$rec->data['allegro_price_start']=$db->FetchResult($result,$i,"allegro_price_start");
$rec->data['allegro_price_buy_now']=$db->FetchResult($result,$i,"allegro_price_buy_now");
$rec->data['allegro_price_min']=$db->FetchResult($result,$i,"allegro_price_min");
$rec->data['allegro_stock']=$db->FetchResult($result,$i,"allegro_stock");
$rec->data['allegro_how_long']=$db->FetchResult($result,$i,"allegro_how_long");
$rec->data['allegro_delivery_who_pay']=$db->FetchResult($result,$i,"allegro_delivery_who_pay");
$rec->data['allegro_delivery_shipment']=$db->FetchResult($result,$i,"allegro_delivery_shipment");
$rec->data['allegro_delivery_priority_shipment']=$db->FetchResult($result,$i,"allegro_delivery_priority_shipment");
$rec->data['allegro_delivery_courier']=$db->FetchResult($result,$i,"allegro_delivery_courier");
$rec->data['allegro_delivery_personal_acceptance']=$db->FetchResult($result,$i,"allegro_delivery_personal_acceptance");
$rec->data['allegro_delivery_other']=$db->FetchResult($result,$i,"allegro_delivery_other");
$rec->data['allegro_delivery_other_text']=$db->FetchResult($result,$i,"allegro_delivery_other_text");
$rec->data['allegro_delivery_abroad']=$db->FetchResult($result,$i,"allegro_delivery_abroad");
$rec->data['allegro_pay_wire_transfer']=$db->FetchResult($result,$i,"allegro_pay_wire_transfer");
$rec->data['allegro_pay_wire_transfer_price']=$db->FetchResult($result,$i,"allegro_pay_wire_transfer_price");
$rec->data['allegro_pay_collect_on_delivery']=$db->FetchResult($result,$i,"allegro_pay_collect_on_delivery");
$rec->data['allegro_pay_collect_on_delivery_price']=$db->FetchResult($result,$i,"allegro_pay_collect_on_delivery_price");
$rec->data['allegro_pay_on_line_pay']=$db->FetchResult($result,$i,"allegro_pay_on_line_pay");
$rec->data['allegro_pay_payu_accept_escrow']=$db->FetchResult($result,$i,"allegro_pay_payu_accept_escrow");
$rec->data['allegro_pay']=$db->FetchResult($result,$i,"allegro_pay");
$rec->data['allegro_pay_wire_transfer_price']=$db->FetchResult($result,$i,"allegro_pay_wire_transfer_price");
$rec->data['allegro_pay_price']=$db->FetchResult($result,$i,"allegro_pay_price");
$rec->data['allegro_bold']=$db->FetchResult($result,$i,"allegro_bold");
$rec->data['allegro_light']=$db->FetchResult($result,$i,"allegro_light");
$rec->data['allegro_favouritism']=$db->FetchResult($result,$i,"allegro_favouritism");
$rec->data['allegro_category_site']=$db->FetchResult($result,$i,"allegro_category_site");
$rec->data['allegro_home_page']=$db->FetchResult($result,$i,"allegro_home_page");
$rec->data['allegro_category']=$db->FetchResult($result,$i,"allegro_category");
?>
