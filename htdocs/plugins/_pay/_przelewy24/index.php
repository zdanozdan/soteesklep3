<?php
/**
* Przej¶cie na strone dot. p³atno¶ci przelewy24.pl
*
* Skrypt ten wy¶wietla formularz HTML przekierowuj±cy klienta na stronê przelewy24.pl.
* Wywo³anie tego skryptu jest odnotowywane w bazie poprzez dodania wpisu transakcji z odpowiednim statusem
* (id_pay_method=12).
* 
* @author m@sote.pl
* @version $Id: index.php,v 1.8 2006/02/15 09:49:01 lukasz Exp $
* @package przelewy24
*/

/**
* \@session float $p24_kwota kwota zamówienia zapisana w sesji; warto¶c potrzebna do weryfikacji autoryzacji
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
@include_once ("../../../../include/head.inc");
@include_once ("config/auto_config/przelewy24_config.inc.php");
@include_once ("plugins/_pay/_przelewy24/lang/_$config->base_lang/lang.inc.php");
@include_once ("plugins/_pay/_przelewy24/lang/_$config->lang/lang.inc.php");

// klasa funckji zwiazanych z przelewy24 - inicjacja obiektu $przelewy24
require_once("plugins/_pay/_przelewy24/include/przelewy24.inc.php");

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

// zmiana ceny z uwzglednieniem promocji _promotions
require_once ("include/price.inc");
$my_price = new MyPrice;
$__amount=$my_price->promotionsAmount($shop->basket->totalAmount());
$__amount*=100; // kwota w groszach

// zapamiêtaj w sesji kwotê przekazywan± do autoryzacji
$p24_kwota=$__amount;
$sess->unregister("p24_kwota");
$sess->register("p24_kwota",$p24_kwota);
// end

$theme->bar($lang->przelewy24_title);
include_once ("plugins/_pay/_przelewy24/html/przelewy24_before.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
