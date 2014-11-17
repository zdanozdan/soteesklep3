<?php
/**
 * Przejscie na strone platnoscipl
*/

require_once ($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/../lib/Basket/basket.php");
require_once ($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/go/_basket/include/my_basket.inc.php");

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("$DOCUMENT_ROOT/../include/head.inc");

include_once ("config/auto_config/allpay_config.inc.php");
// klasa funckji zwiazanych z platnoscipl - inicjacja obiektu $planosciPL
require_once("plugins/_pay/_allpay/include/allpay.inc.php");
if (! empty($_SESSION['global_basket_data'])) {
    require_once ("go/_basket/include/my_basket.inc.php");
    $basket=& new MyBasket;
    $my_basket=&$basket;
    $my_basket->display="text";
}

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

// sprawdz, czy zostal juz zainicjowany koszyk; jesli nie to nie zezwalaj na
// wprowadzenie danych
if (empty($_SESSION['my_basket']) && (! is_object($my_basket))) {
    exit;
}

// odczytaj order_id
if (! empty($_SESSION['global_order_id'])) $order_id=$_SESSION['global_order_id'];
if ((empty($order_id)) && (! empty($global_order_id))) $order_id=$global_order_id;

global $shop;
$my_price = new MyPrice;
$shop->basket();
$amount1=$shop->basket->amount();
$amount=$my_price->promotionsAmount($_SESSION['global_order_amount']);

global $allpay;
$allpay=new allpay($amount);

$theme->theme_file("_allpay/allpay_before.html.php");
$allpay->form();

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
