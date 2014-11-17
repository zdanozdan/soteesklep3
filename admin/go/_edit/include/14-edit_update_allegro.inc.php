<?php
/**
* Aktualizuj w baze wartosc pola zwi±zane z ceneoPasa¿
*
* @author  rdiak@sote.pl
* @version $Id: edit_update_allegro.inc.php,v 2.4 2006/06/28 08:57:02 lukasz Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

if ($global_secure_test!=true) {
    die ("Forbidden");
}

require_once("include/metabase.inc");
global $database;
global $mdbd;
global $allegro_config;

//print_r($datat);

// pobieramy z tablicy main user_id produktu
$user_id=$mdbd->select("user_id","main","id=?",array($id=>"int"));

// sprawdzamy czy rekord juz istnieje w bazie
$count=$mdbd->select("count(*)","allegro_auctions","user_id=?",array($user_id=>"string"));

// odczytaj dane z formularza
if (! empty($_REQUEST['item'])) {
    $item=&$_REQUEST['item'];
} else {
    die ("Forbidden: Unknown item");
}


$item['allegro_price_start']=preg_replace("/\,/",".",$item['allegro_price_start']);
$item['allegro_price_buy_now']=preg_replace("/\,/",".",$item['allegro_price_buy_now']);
$item['allegro_price_min']=preg_replace("/\,/",".",$item['allegro_price_min']);
$item['allegro_pay_wire_transfer_price']=preg_replace("/\,/",".",$item['allegro_pay_wire_transfer_price']);
$item['allegro_pay_collect_on_delivery_price']=preg_replace("/\,/",".",$item['allegro_pay_collect_on_delivery_price']);

if($allegro_config->allegro_mode == 'true') {
    $send='product';
} else {
    $send='test';
}    

if($count == 0) {
    $database->sql_insert("allegro_auctions",array(
                            'user_id'=> $user_id,
                            'allegro_auction_type'=>@$item['allegro_auction_type'],
                            'allegro_product_name'=>@$item['allegro_product_name'],
                            'allegro_product_description'=>@$item['allegro_product_description'],
                            'allegro_photo'=>@$item['allegro_photo'],
                            'allegro_miniature'=>@$item['allegro_miniature'],
                            'allegro_price_start'=>@$item['allegro_price_start'],
                            'allegro_price_buy_now'=>@$item['allegro_price_buy_now'],
                            'allegro_price_min'=>@$item['allegro_price_min'],
                            'allegro_stock'=>@$item['allegro_stock'],
                            'allegro_how_long'=>@$item['allegro_how_long'],
                            'allegro_delivery_who_pay'=>@$item['allegro_delivery_who_pay'],
                            'allegro_delivery_shipment'=>@$item['allegro_delivery_shipment'],
                            'allegro_delivery_priority_shipment'=>@$item['allegro_delivery_priority_shipment'],
                            'allegro_delivery_courier'=>@$item['allegro_delivery_courier'],
                            'allegro_delivery_personal_acceptance'=>@$item['allegro_delivery_personal_acceptance'],
                            'allegro_delivery_other'=>@$item['allegro_delivery_other'],
                            'allegro_delivery_abroad'=>@$item['allegro_delivery_abroad'],
                            'allegro_pay_wire_transfer'=>@$item['allegro_pay_wire_transfer'],
                            'allegro_pay_wire_transfer_price'=>@$item['allegro_pay_wire_transfer_price'],
                            'allegro_pay_collect_on_delivery'=>@$item['allegro_pay_collect_on_delivery'],
                            'allegro_pay_collect_on_delivery_price'=>@$item['allegro_pay_collect_on_delivery_price'],
                            'allegro_pay_on_line_pay'=>@$item['allegro_pay_on_line_pay'],
                            'allegro_pay_payu_accept_escrow'=>@$item['allegro_pay_payu_accept_escrow'],
                            'allegro_pay' =>@$item['allegro_pay'],
                            'allegro_pay_wire_transfer_price'=>@$item['allegro_pay_wire_transfer_price'],
                            'allegro_pay_price'=>@$item['allegro_pay_price'],
                            'allegro_bold'=>@$item['allegro_bold'],
                            'allegro_light' =>@$item['allegro_light'],
                            'allegro_favouritism'=>@$item['allegro_favouritism'],
                            'allegro_category_site'=>@$item['allegro_category_site'],
                            'allegro_home_page'=>@$item['allegro_home_page'],
                            'allegro_category'=>@$item['allegro_category'],
                            'allegro_send'=>$send,
                        ));
} else {
    $database->sql_update("allegro_auctions","user_id=$user_id",
                    array(
                            'allegro_auction_type'=>@$item['allegro_auction_type'],
                            'allegro_product_name'=>@$item['allegro_product_name'],
                            'allegro_product_description'=>@$item['allegro_product_description'],
                            'allegro_photo'=>@$item['allegro_photo'],
                            'allegro_miniature'=>@$item['allegro_miniature'],
                            'allegro_price_start'=>@$item['allegro_price_start'],
                            'allegro_price_buy_now'=>@$item['allegro_price_buy_now'],
                            'allegro_price_min'=>@$item['allegro_price_min'],
                            'allegro_stock'=>@$item['allegro_stock'],
                            'allegro_how_long'=>@$item['allegro_how_long'],
                            'allegro_delivery_who_pay'=>@$item['allegro_delivery_who_pay'],
                            'allegro_delivery_shipment'=>@$item['allegro_delivery_shipment'],
                            'allegro_delivery_priority_shipment'=>@$item['allegro_delivery_priority_shipment'],
                            'allegro_delivery_courier'=>@$item['allegro_delivery_courier'],
                            'allegro_delivery_personal_acceptance'=>@$item['allegro_delivery_personal_acceptance'],
                            'allegro_delivery_other'=>@$item['allegro_delivery_other'],
                            'allegro_delivery_abroad'=>@$item['allegro_delivery_abroad'],
                            'allegro_pay_wire_transfer'=>@$item['allegro_pay_wire_transfer'],
                            'allegro_pay_wire_transfer_price'=>@$item['allegro_pay_wire_transfer_price'],
                            'allegro_pay_collect_on_delivery'=>@$item['allegro_pay_collect_on_delivery'],
                            'allegro_pay_collect_on_delivery_price'=>@$item['allegro_pay_collect_on_delivery_price'],
                            'allegro_pay_on_line_pay'=>@$item['allegro_pay_on_line_pay'],
                            'allegro_pay_payu_accept_escrow'=>@$item['allegro_pay_payu_accept_escrow'],
                            'allegro_pay' =>@$item['allegro_pay'],
                            'allegro_pay_wire_transfer_price'=>@$item['allegro_pay_wire_transfer_price'],
                            'allegro_pay_price'=>@$item['allegro_pay_price'],
                            'allegro_bold'=>@$item['allegro_bold'],
                            'allegro_light' =>@$item['allegro_light'],
                            'allegro_favouritism'=>@$item['allegro_favouritism'],
                            'allegro_category_site'=>@$item['allegro_category_site'],
                            'allegro_home_page'=>@$item['allegro_home_page'],
                            'allegro_category'=>@$item['allegro_category'],
                            'allegro_send'=>$send,
    ));
}
?>
