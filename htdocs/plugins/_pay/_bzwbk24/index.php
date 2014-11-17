<?php
/**
* Przej¶cie na strone dot. p³atno¶ci bzwbk24.pl
*
* Skrypt ten wy¶wietla formularz HTML przekierowuj±cy klienta na stronê bzwbk24.pl.
* Wywo³anie tego skryptu jest odnotowywane w bazie poprzez dodania wpisu transakcji z odpowiednim statusem
* (id_pay_method=8).
* 
* @author tomasz@mikran.pl
* @version $Id: index.php,v 1.2 2006/11/23 17:57:58 tomasz Exp $
* @package bzwbk24
*/



$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
@include_once ("../../../../include/head.inc");
@include_once ("config/auto_config/bzwbk24_config.inc.php");
@include_once ("plugins/_pay/_bzwbk24/lang/_$config->base_lang/lang.inc.php");
@include_once ("plugins/_pay/_bzwbk24/lang/_$config->lang/lang.inc.php");

if (! empty($_SESSION['global_basket_data'])) {
    require_once ("go/_basket/include/my_basket.inc.php");
    $basket=& new MyBasket;
    $my_basket=&$basket;
    $my_basket->display="text";
}

// // naglowek
// $theme->head();
// $theme->page_open_head("page_open_1_head");

// sprawdz, czy zostal juz zainicjowany koszyk; jesli nie to nie zezwalaj na
// wprowadzenie danych
if (empty($_SESSION['my_basket']) && (! is_object($my_basket))) 
{
   //robimy wypad z tej strony za pomoca js
   print "<script type=\"text/javascript\">document.location.href='http://".$config->www."'</script>";
}
else
{
   // odczytaj order_id
   if (! empty($_SESSION['global_order_id'])) $order_id=$_SESSION['global_order_id'];
   if ((empty($order_id)) && (! empty($global_order_id))) $order_id=$global_order_id;
   
   // je¶li klient zdecydowa³ siê na zap³ate to przekierowujemy go na strone koñcow±
   //   if (! empty($_POST['submit_transfer_bzwbk24'])) 
   // {
      global $shop;
      $final_basket=& new MyBasket;
      $bzwbkAmount = sprintf("%.2f %s",$my_basket->totalAmount(), $shop->currency->currency);
      
      require_once ("go/_basket/include/my_basket.inc.php");
      require_once ("include/order/send.inc"); 
      $order_send =& new OrderSend; 

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
         $theme->head();
         $theme->page_open_head("page_open_1_head");

         $theme->bar($lang->bzwbk24_order_finished);

         include_once ("plugins/_pay/_bzwbk24/html/bzwbk24_after.html.php");
         
         // wyswietl informacje o wyslaniu zamowienia
         $theme->send_confirm();
      } 
      else 
      {
         // naglowek
         $theme->head();
         $theme->page_open_head("page_open_1_head");
         $theme->send_error();
      } 
      // } 
//   else 
//   {
      //    $theme->bar($lang->bzwbk24_title);
      //      include_once ("plugins/_pay/_bzwbk24/html/bzwbk24_before.html.php");
      //   }
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
