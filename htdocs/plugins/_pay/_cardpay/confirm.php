<?php
/**
* Wyslanie zamowienia platnosc z Przelewy24.pl. Wyslanie zamowienia            
* na konto e-mail + potwierdzenie dla klienta                          
*
* \@session string $global_lock_send zapamietanie informacji, ze zamowienie zostalo juz wyslane
*
* @author m@sote.pl
* @version $Id: confirm.php,v 1.1 2005/10/26 12:45:24 lukasz Exp $
* @package przelewy24
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");

// wyslij mailem zamowienie
include_once("$DOCUMENT_ROOT/go/_register/include/send_order.inc.php");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

if ($confirm==true) {
    // zapamietaj, ¿e zosta³o wywolane wyslanie zamowienia, pozwoli to na zabronienie
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