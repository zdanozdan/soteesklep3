<?php
/**
* Przej¶cie na strone dot. p³atno¶ci kart±
* 
* @author lukasz@sote.pl
* @version $Id: index.php,v 1.2 2005/12/12 12:05:41 lukasz Exp $
* @package cardpay
*/


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
@include_once ("../../../../include/head.inc");
@include_once ("config/auto_config/cardpay_config.inc.php");
@include_once ("plugins/_pay/_cardpay/lang/_$config->base_lang/lang.inc.php");
@include_once ("plugins/_pay/_cardpay/lang/_$config->lang/lang.inc.php");
global $my_form_check;
global $card_form;
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
	$theme->go2main();
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
// end

$theme->bar($lang->cardpay_title);

//$theme->theme_file("_card_pay/form.html.php");
if (!empty($_POST['card'])) {
	$card_form=$_POST['card'];
} else {
	$theme->theme_file("_card_pay/form.html.php");
	$card_form=array();
}

require("$DOCUMENT_ROOT/plugins/_pay/_cardpay/include/my_form_check.inc.php");

$my_form_check= new MyFormCheck();
$my_form_check->fun=array("card_id"=>"card",
						"cvv"=>"cvv",
						"exp_year"=>"exp_year",
						"exp_month"=>"exp_month"
						);
$my_form_check->errors=array("card_id"=>$lang->errors['bad_card_id'],
							"cvv"=>$lang->errors['bad_cvv'],
							"exp_year"=>$lang->errors['bad_year'],
							"exp_month"=>$lang->errors['bad_month'],
							);
$my_form_check->form=&$card_form;
if ($my_form_check->form_test()) {
	require ("./include/order_register.inc.php");
	require_once ("go/_basket/include/my_basket.inc.php");
	require_once ("include/order/send.inc");
	$order_send =& new OrderSend;

	if ($order_send->send()) {
		// zapamietaj, ze zostalo wywolane wyslanie zamowienia, pozwoli to na zabronienie
		// ponownego wyslanie tego samego zamowienia
		$global_lock_send=true;
		$global_lock_basket=false;
		$global_lock_register=false;
		$sess->register("global_lock_send",$global_lock_send);
		$sess->register("global_lock_basket",$global_lock_basket);
		$sess->register("global_lock_register",$global_lock_register);

		// wyswietl informacje o wyslaniu zamowienia
		$theme->send_confirm();
	} else {
		$theme->send_error();
	}

} else if (!empty($_POST['card'])) $theme->theme_file("_card_pay/form.html.php");


$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
