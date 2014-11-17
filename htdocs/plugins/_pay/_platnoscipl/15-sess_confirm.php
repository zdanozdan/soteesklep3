<?php
// +----------------------------------------------------------------------+
// | SOTEeSKLEP version 2                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1999-2002 SOTE www.sote.pl                             |
// +----------------------------------------------------------------------+
// | Wyslanie zamowienia platnosc eCard. Wyslanie zamowienia              |
// | na konto e-mail + potwierdzenie dla klienta                          |
// +----------------------------------------------------------------------+
// | authors: Marek Jakubowicz <m@sote.pl>                                |
// +----------------------------------------------------------------------+
//
// $Id: sess_confirm.php,v 1.5 2006/06/29 14:24:19 lukasz Exp $

/**
 * @session string $global_lock_send zapamietanie informacji, ze zamowienie zostalo juz wyslane
 */

// Jesli w sesji zapisany jest obiekt, to klasa tego obiektu, 
// musi byc zaladowana przed otworzeniem sesji!

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
//require_once ("$DOCUMENT_ROOT/../include/metabase.inc");

global $mdbd;
$p24_session=$_GET['sess_id'];
$order_id=$mdbd->select('order_id','order_register',"session_id='$p24_session'",'','LIMIT 1');
if (!empty($order_id)) {
	$session=$mdbd->select('data','order_session',"order_id='$order_id'");
	if (!empty($session)) {
		$_SESSION=unserialize($session);
		// zapalamy flage
		$session_restored=true;
	}
}
// wyslij mailem zamowienie
include_once("$DOCUMENT_ROOT/go/_register/include/send_order.inc.php");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

if ($confirm==true) {
    // zapamietaj, ze zostalo wywolane wyslanie zamowienia, pozwoli to na zabronienie
    // ponownego wyslanie tego samego zamowienia
#    $global_lock_send=true;
#    $global_lock_basket=false;
#    $global_lock_register=false;
#    $sess->register("global_lock_send",$global_lock_send);
#    $sess->register("global_lock_basket",$global_lock_basket);
#    $sess->register("global_lock_register",$global_lock_register);
     // wyswietl informacje o wyslaniu zamowienia
    $theme->send_confirm();
} else {
    $theme->send_error();
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
