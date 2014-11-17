<?php
/**
 * Przekieruj uzytwkonika na odpowiednia strone systemu platnosci       
 * w zaleznosci od wybranej opcji, tj w zaleznosci od  wcisnietego      
 * przycisku submit. Strona ta nie jest bezposrenido wywolywana z       
 * przegladarki.                                                        
 * Zapisz transakcje w systemie rejestracji zamowien.                   
 *
 * @require bool $global_lock_register=true konieczne wczesniejsze wywolanie formularza zamowienia
 *
 * @author m@sote.pl
 * @version $Id: register3.php,v 1.2 2006/11/23 17:57:58 tomasz Exp $
* @package    register
 */

// Jesli w sesji zapisany jest obiekt, to klasa tego obiektu,
// musi byc zaladowana przed otworzeniem sesji!
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
	$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}

$global_database=true;
$global_secure_test=true;
require_once ("../../../include/head.inc");

$shop->basket();
if ($shop->basket->isEmpty()) 
{
   $theme->go2main();
   exit;
}

// sprawdz, czy wczesniej wywolano strone z formularzem zmowienia
if (my(@$_SESSION['global_lock_register'])!=true) {
	// wyswietl strone z linkiem do glownej strony
   $theme->go2main();
   exit;
}

if (! empty($_SESSION['global_basket_data'])) {
 	require_once ("./include/my_ext_basket.inc.php");
 	$basket=& new My_Ext_Basket();
 	$basket->init();
 	$my_basket=&$basket;
 	$my_basket->display="text";
}



// odczytaj dane z sesji z wczesniej wypelnionych formularzy
if (! empty($_SESSION['form'])) {
	$form=&$_SESSION['form'];
}
if (! empty($_SESSION['form_cor'])) {
	$form_cor=&$_SESSION['form_cor'];
}
// odczytaj dane z sesji dotycz±ce polecenia produktów
if (! empty($_SESSION['recom'])) {
	$recom=&$_SESSION['recom'];
}

$value ="";
if (! empty($_SESSION['payment'])) {
   $value = $_SESSION['payment'];
}
else
{
   die ("Blêdne okreslenie metody platnosci");
   $theme->go2main();
   exit;
}

chdir("$DOCUMENT_ROOT/go/_register/");

//TEST ONLY
//foreach ( $_REQUEST as $key=>$val ) 
//{
   //echo "klucz:$key, value:$_POST[$key]\n    ";
// $value = $_REQUEST[$key];
   
   // czy wybrano platnosc za zaliczeniem pocztowym?
   //if (! empty($_POST['submit_post'])) 
   if ($value == "submit_post")
   {
      $global_id_pay_method=1;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/go/_register/_post/index.php");
      //exit;
   }

   // czy wybrano platnosc karta kredytowa za posrednictwem systemu eCard?
   //   if (! empty($_POST['submit_ecard'])) {
   if ($value == "submit_ecard") 
   {
      $global_id_pay_method=2;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/go/_register/_ecard/index.php");
      //exit;
   }

   // czy wybrano platnosc karta kredytowa za posrednictwem systemu PolCard?
   //if (! empty($_POST['submit_polcard'])) {
   if ($value == "submit_polcard") 
   {
      $global_id_pay_method=3;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_polcard/index.php");
      //exit;
   }

   // czy wybrano platnosc za posrednictwem systemu Inteligo?
   //   if (! empty($_POST['submit_inteligo'])) {
   if ($value == "submit_inteligo") 
   {
      $global_id_pay_method=4;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_inteligo/index.php");
      //exit;
   }

   // czy wybrano platnosc karta kredytowa za posrednictwem systemu PolCard?
   //if (! empty($_POST['submit_mbank'])) {
   if ($value == "submit_mbank") 
   {
      $global_id_pay_method=5;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_mbank/index.php");
      //exit;
   }

   // czy wybrano platnosc karta kredytowa za posrednictwem systemu PolCard?
   //if (! empty($_POST['submit_citi'])) {
   if ($value == "submit_citi")
   {
      $global_id_pay_method=6;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_citiconnect/index.php");
      //exit;
   }

   // czy wybrano platnosc karta kredytowa za posrednictwem systemu PolCard?
   //if (! empty($_POST['submit_payu'])) {
   if ($value == "submit_payu")
   {
      $global_id_pay_method=7;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_payu/index.php");
      //exit;
   }

   // czy wybrano platnosc za przelewem BZWBK24 ?
   //if (! empty($_POST['submit_bzwbk24'])) 
   if ($value == "submit_bzwbk24")
   {
      $global_id_pay_method=8;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_bzwbk24/index.php");
      //exit;
   }

   // czy wybrano platnosc przelewem?
   //if (! empty($_POST['submit_transfer'])) 
   if ($value == "submit_transfer")
   {
      $global_id_pay_method=11;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/go/_register/_post/index.php");
      //exit;
   }

   // czy wybrano platnosc przelewem?
   //   if (! empty($_POST['submit_przelewy24'])) {
   if ($value == "submit_przelewy24")
   {
      $global_id_pay_method=12;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_przelewy24/index.php");
      //exit;
   }

   // czy wybrano platnosc paypal ?
   //if (! empty($_POST['submit_paypal'])) {
   if ($value == "submit_paypal") 
   {
      $global_id_pay_method=101;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_paypal/index.php");
      //exit;
   }
   // czy wybrano platnosc PlatnosciPL ?

   //if (! empty($_POST['submit_platnoscipl'])) {
   if ($value == "submit_platnoscipl")
   {
      $global_id_pay_method=20;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_platnoscipl/index.php");
      //exit;
   }

   // czy wybrano platnosc Allplay ?
   //if (! empty($_POST['submit_allpay'])) {
   if ($value == "submit_allpay")
   {
      $global_id_pay_method=21;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_allpay/index.php");
      //exit;
   }

   // czy wybrano plantosc karta ?
   //   if (! empty($_POST['submit_cardpay'])) {
   if ($value == "submit_cardpay")
   {
      $global_id_pay_method=110;
      require_once ("./include/order_register.inc.php");
      // zapisz transakcje w bazie danych
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/plugins/_pay/_cardpay/index.php");
      //exit;
   }

   // czy wybrano plantosc gotówk± ?
   //   if (! empty($_POST['submit_cash'])) {
   if ($value == "submit_cash") 
   {
      $global_id_pay_method=81;
      // zapisz transakcje w bazie danych
      require_once ("./include/order_register.inc.php");
      $g = $my_basket->basket_google();
      require_once("$DOCUMENT_ROOT/go/_register/_post/index.php");
      //exit;
   }

print "<form style=\"display:none;\" name=\"utmform\">";
print "<textarea id=\"utmtrans\">\n";
print $g;
print "</textarea></form>";

print "<script type=\"text/javascript\">__utmSetTrans()</script>";
?>
