<?php
/**
* Wyslanie zamowienia platnosc PolCard. Wyslanie zamowienia            |
* na konto e-mail + potwierdzenie dla klienta                          |
*
* \@session string $global_lock_send zapamietanie informacji, ze zamowienie zostalo juz wyslane
*
* @author m@sote.pl
* @version $Id: sess_confirm.php,v 1.6 2005/01/20 15:00:33 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag��wek skryptu.
*/
require_once ("../../../../include/head.inc");

// wyslij mailem zamowienie
include_once("$DOCUMENT_ROOT/go/_register/include/send_order.inc.php");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

if ($confirm==true) {
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

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
