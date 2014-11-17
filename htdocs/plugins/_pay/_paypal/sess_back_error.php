<?php
/**
 * Powrot po autoryzacji z paypal, strona po przekierowaniu ze skryptu back.php
 * gdzie dodalismy numer sesji
 *
 * @author  r@sote.pl
 * @version $Id: sess_back_error.php,v 1.2 2005/03/01 14:03:50 scalak Exp $
 * @package htdocs
 * @subpackage paypal
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

$theme->head();
$theme->page_open_head("page_open_1_head");

$paypal=new payPal;
$paypal->payPalGetError();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>