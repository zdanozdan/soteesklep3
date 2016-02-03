<?php
/**
 * Wyslanie zamowienia za zaliczeniem pocztowym. Wyslanie zamowienia    |
 * na konto e-mail + potwierdzenie dla klienta                          |
 *
 * \@session string $global_lock_send zapamietanie informacji, ze zamowienie zostalo juz wyslane 
 * 
 * @author m@sote.pl
 * @version $Id: index.php,v 1.1 2006/09/27 21:53:10 tomasz Exp $
* @package    register
* @subpackage post
 */
 

// Jesli w sesji zapisany jest obiekt, to klasa tego obiektu, 
// musi byc zaladowana przed otworzeniem sesji!
global $DOCUMENT_ROOT;
$global_database=true;
$global_secure_test=true;

/**
* Nag³ówek skryptu
*/
@include_once ("../../../../include/head.inc");

if (! empty($_SESSION['global_basket_data'])) {
   require_once ("go/_basket/include/my_basket.inc.php");
   $basket=& new MyBasket;
   $my_basket=&$basket;
   $my_basket->display="text";
}

require_once ("include/order/send.inc");
$order_send =& new OrderSend;

global $shop;
$totalAmount = sprintf("%.2f %s",$my_basket->totalAmount(), $shop->currency->currency);

// odczytaj order_id
if (! empty($_SESSION['global_order_id'])) $order_id=$_SESSION['global_order_id'];
if ((empty($order_id)) && (! empty($global_order_id))) $order_id=$global_order_id;

global $__check;

if ($order_send->send()) 
{
    // zapamietaj, ze zostalo wywolane wyslanie zamowienia, pozwoli to na zabronienie
    // ponownego wyslanie tego samego zamowienia
    $global_lock_send=true;
    $global_lock_basket=false;
    $global_lock_register=false;
    $sess->register("global_lock_send",$global_lock_send);
    $sess->register("global_lock_basket",$global_lock_basket);
    $sess->register("global_lock_register",$global_lock_register);

    // naglowek
    //$theme->head();
    $theme->page_open_head("page_open_1_head");

    $theme->bar($lang->register_send_title);
    //$theme->theme_file("send_confirm_summary.html.php");
    // wyswietl informacje o wyslaniu zamowienia
    $theme->send_confirm();
} 
else 
{
    // naglowek
    //$theme->head();
    $theme->page_open_head("page_open_1_head");
    $theme->bar($lang->register_send_title);
    $theme->send_error();
}

$theme->page_open_head("foot");

// stopka
//$theme->foot();
//include_once ("include/foot.inc");
?>
