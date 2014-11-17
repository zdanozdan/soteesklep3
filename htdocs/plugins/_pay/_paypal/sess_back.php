<?php
/**
 * Powrot po autoryzacji Inteligo i przekierowaniu z sesja
 *
 * @author rdiak@sote.pl
 * @version $Id: sess_back.php,v 1.5 2006/02/15 09:49:00 lukasz Exp $
 * @package soteesklep pay
 */

// Jesli w sesji zapisany jest obiekt, to klasa tego obiektu,
// musi byc zaladowana przed otworzeniem sesji!

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("$DOCUMENT_ROOT/../include/head.inc");
require_once ($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/../lib/Basket/basket.php");
require_once ($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/go/_basket/include/my_basket.inc.php");

@include_once ("config/auto_config/paypal_config.inc.php");
include("./include/paypal.inc.php");


if (! empty($_REQUEST['ID'])) {
    $order_id=$_REQUEST['ID'];
    if (! ereg("^[0-9]+$",$order_id)) {
        $theme->go2main();
	exit;
    }
} else {
    $theme->go2main();
    exit;
}



$theme->head();
$theme->page_open_head("page_open_1_head");

$paypal=new payPal;
$paypal->payPalGetOk();


// wyslij mailem zamowienie
include_once("$DOCUMENT_ROOT/go/_register/include/send_order.inc.php");

$theme->send_confirm();
// zamknij cala sesje
session_unset();
$start_new_session=1;
$sess->register("start_new_session",$start_new_session);
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
