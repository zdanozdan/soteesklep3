<?php
/**
* Zawarto¶æ koszyka.
* Przedstawienie stanu koszyka, podliczenie zawartosci, dodanie produktu do koszyka, wybor dostawcy towaru. <br>
* <br /><br />
* \@session real $global_basket_amount warto¶æ zamówienia, bez kosztów dostawy<br />
* \@session int  $global_basket_count ilo¶æ produktów w koszyku<br />
* \@session bool $global_lock_register=false nie zezwalaj na przej¶cie do wys³ania zamówienia bez przej¶cia przez strone _register<br />
* \@session bool  $global_lock_send=false zezwalaj na wyslanie zamowienia w tej sesji<br />
* \@session array $basket_data dane koszyka<br />
* \@session array $wishlist_data dane przechowalni<br />
*
* @author  lukasz@sote.pl
* @version $Id: index2.php,v 1.2 2006/11/30 19:42:26 tomasz Exp $
* @package    basket
*/
//error_reporting(E_ALL);

// blokada przed back z formularza zamówienia
$__basket_add_lock=true;

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu
*/
require_once ("../../../include/head.inc");

//print_r($_SESSION['global_delivery']);

// Report all PHP errors (bitwise 63 may be used in PHP 3)
//error_reporting(E_ALL);


// nowy koszyk
/**
* Nowy koszyk - klasa My_Ext_Basket, obs³uga produktów, wy¶wietlanie ich listy, modyfikacja tej listy, zapis danych w sesji, bazie danych i pliku cookie - itp.
*
*/

//error_reporting(E_ALL);

$http_referer = $HTTP_SERVER_VARS['HTTP_REFERER'];

require_once("./include/my_ext_basket.inc.php");
// tworzymy koszyk
$basket=& new My_Ext_Basket();
// wymagane przez temat aby wy¶wietliæ poprawnie liste
$my_basket=&$basket;
// przechowalnia - konieczna do przenoszenia produtków
$wishlist=& new My_Ext_Basket('wishlist');
// tworzymy relacje miêdzy jednym a drugim
$basket->_move_target=&$wishlist;
$wishlist->_move_target=&$basket;
// inicjujemy - ³adujemy informacje z bazy/sesji
$wishlist->init();
$basket->init();
// end nowy koszyk

//sprawdzamy czy koszyk jest pusty, jesli tak to exit
$shop->basket();
if ($shop->basket->isEmpty()) 
{
   $theme->go2main();
   exit;
}

/**
* Klasa funckji: oblicz koszty dostawy, wy¶wietl listê dostawców itp.
*/
require_once("./include/delivery.inc.php");

// odczytaj numer id produktu, ktory jest dodawany do koszyka
// jesli id nie jest puste, to produkt jest dodawany do ksozyka,
// w przeciwnym razie przedstawiany jest tylko status koszyka
$id="";
if (!empty($_REQUEST['id'])) 
{
   $id=$_REQUEST['id'];
}

// odczytaj wybranego dostawce, o ile user wybral zmiane dostawcy
if (! empty($_REQUEST['delivery'])) 
{
   $delivery=$_REQUEST['delivery'];
} 
else 
{
   $delivery=array();
}

if (! empty($_SESSION['global_delivery'])) 
{
   $global_delivery=$_SESSION['global_delivery'];
}

// tworzymy tablice nowych ilo¶ci produktów (je¿eli s± one ustawione)
if (empty($id) && isset($_POST['num'])) 
{
   foreach ($_POST['num'] as $int_id => $val) 
   {
      $num[] = array( $int_id => "$val");
   }
}

// przypisujemy odpowiedni± warto¶æ do wewnêtrznego id usuwanego produktu
if (empty($id) && isset($_POST['del'])) 
{
   foreach ($_POST['del'] as $int_id => $val) 
   {
      $del[] = array( $int_id => "$val");
   }
}
// tworzymy tablice produktów do przeniesienia
if (empty($id) && isset($_POST['move'])) 
{
   foreach ($_POST['move'] as $int_id => $val) 
   {
      $move[] = array( $int_id => "$val");
   }
}
// ustawiamy pozosta³e zmienne o ile istniej±
$options=@$_POST['options'];
$basket_cat=@$_POST['basket_cat'];
$ext_basket=@$_POST['basket'];

/**
* Sprawdz jaki jest rodzaj wywolania skryptu.
* Czy jest to dodanie do koszyka, update koszyka, czy przejscie dalej do formularza z danymi
* itp.
*/
$submit_type="";
if (! empty($_POST['submit_update'])) {
    $submit_type="update";  // podlicz
}
if (! empty($_POST['submit_proceed'])){
   $submit_type="proceed"; // dalej
}
if (! empty($_POST['del'])) {
    $submit_type="delete";  // kasuj wybrany produkt
}
if (!empty($_POST['move'])) {
   $submit_type="move";
}

// odczytaj czy chcemy logowaæ usera
if (! empty($_POST['type'])) {
    $submit_type=$_POST['type'];
} 
// a mo¿e chcemy go wylogowaæ ?
if (! empty($_REQUEST['action'])) {
    $submit_type=$_REQUEST['action'];
} 

if ((empty($submit_type)) && (! empty($id))) {
   $submit_type="add";
}

$basket_change=false;
// koszyk rejestrujemy po ka¿dym dzia³aniu - aby mia³o to miejsce minimum razy - czasem nie robimy tego tutaj

$theme->bad_login = false;

if ($submit_type=="proceed" || $_REQUEST['step']=="2")
{
   $step=2;
   $submit_type = "step2";
}
else
{
   $step=1;
}

if (empty($_SESSION['ajax_pay_number']) && $submit_type != "update")
{
   $step=1;
   $submit_type = "step1";
}

$sess->register("current_step",$step);

// klasa obslugujaca sprawdzanie poprawnosci formularzy HTML
include_once ("include/form_check.inc");
include_once ("./include/my_form_check.inc.php");
$form_check = new MyFormCheck;
$form_cor_check = new MyFormCheck;

// odczytaj parametry przekazane z formularza HTML
// ktore sa zapisane w tablicy form
if (! empty($_POST['form'])) 
{
   $form=$_POST['form'];
   if (!empty($_SESSION['form'])) {
      $form1=$_SESSION['form'];
      $form=array_merge($form1,$form);
   }
   $form_check->form=&$form; // przekaz dane z formularza
} 

if (! empty($_POST['form_cor'])) 
{
   $form_cor=$_POST['form_cor'];
   if (!empty($_SESSION['form_cor'])) {
      $form_cor1=$_SESSION['form_cor'];
      $form_cor=array_merge($form_cor1,$form_cor);
   }
   $form_cor_check->form=&$form_cor; // przekaz dane z formularza
} 

// definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
// (z klasy FormCheck)
$form_check->register_fields();
$form_cor_check->register_cor_fields();

$form_check->errors=$lang->register_billing_form_errors;
$form_cor_check->errors=$lang->register_billing_form_errors;

$val = true;
$sess->register("head_display",$val);
$da = "true";
$sess->register("disable_ajax",$da);
      
$display_step=$step;
$all_done=false;
$delivery_address_changed=false;

switch ($submit_type) 
{
   case "delivery_change":
      $sess->register("form",$form);
      $sess->register("form_try",$form);
      $req_val = $_REQUEST['value'];
      if ($req_val=="no")
      {
         $sess->register("corr_addr",$req_val);
      }
      else
      {
         if (!empty($_POST['form_cor'])) 
         {
            $form_cor = $_POST['form_cor'];
            $sess->register("form_cor",$form_cor);
         }
         $sess->unregister("corr_addr");
      }
      $display_step=2;
      break;

   case "form_check":
      $sess->register("form",$form);
      $result = $form_check->form_test();
      if ($result==true)
      {
         if (!empty($form_cor))
         {
            $result = $form_cor_check->form_test();
            $theme->add_cor_form($form_cor_check);
            if ($result==true)
            {
               $all_done=true;
               $sess->register("form_cor",$form_cor);
               //print "true";
            }
            else
            {
               $sess->register("form_cor",$form_cor);
               $sess->register("form_try",$form);
               $display_step=2;
            }
         }
         else
            $all_done=true;
      }
      else
      {
         $sess->register("form_try",$form);
         $display_step=2;
         //sprawdzamy tak¿e adres wysylkowy je¶li istnieje
         if (!empty($form_cor))
         {
            $result = $form_cor_check->form_test();
            $theme->add_cor_form($form_cor_check);
            $sess->register("form_cor",$form_cor);
         }
      }
   break;
   case "logout":
      $delivery_obj->calc();
      require_once("go/_users/include/logout.inc.php");
      $logout->logout_user();   
      $basket->proceed(@$num,@$del);
      $basket->register();
      $theme->head();
      $sess->unregister("form");
      $sess->unregister("form_try");
      $sess->unregister("form_cor");
      $display_step=2;
      break;
   case "login":
      $delivery_obj->calc();
      // logowanie
      require_once("go/_users/include/login.inc.php");
      $login = new LoginUsers;
      if ($login->login($form['login'],$form['password'])) 
      {
         $global_login=$form['login']; // nazwa zalogowanego uzytkownika
         // poprawne logowanie :)
         $form=&$login->form;                
                       
         // od wersji 3.0 global_prv_key = $public_key
         $global_prv_key=md5($config->salt);
        
         $sess->register("form",$form);
         $sess->register("global_prv_key",$global_prv_key);                    
         $sess->register("global_login",$global_login);
         $sess->unregister("form_try");
         $sess->unregister("form_cor");

         $basket->proceed(@$num,@$del);
         $basket->register();
      }
      else
      {
         $theme->bad_login=true;
      }
      $display_step=2;
      break;
    case "update":
       $_SESSION['depository_status']="true";
       $basket_change=true;
       $basket->update_many($num);
       $basket->_save_to_db();
    break;
    case "delete":
       $basket_change=true;
       $basket->del_many_prod($del);
       $basket->register();
       break;
   case "move":
      $basket_change=true;
      $basket->move_many_prod($move);
      // rejestrujemy przechowalnie
      $wishlist->register();
      // tutaj nie rejestrujemy koszyka - odbywa siê to podczas aktualizacji produktów w basket_update
      //    $basket->register();
      break;
   case "step2":
   case "proceed":
      $delivery_obj->calc();
      $basket_change=true;
      $basket->proceed(@$num,@$del);
      $basket->register();
      $display_step=2;
      break;
   case "add":
      if ($basket->check_options($id,@$num,$options,$basket_cat,$ext_basket) == false)
      {
         $basket_change=true;
         $basket->add_prod($id,@$num,$options,$basket_cat,$ext_basket);
         $basket->register();
      }
      else
      {
         $location = "Location:/go/_info/options_only.php?id=" . $id;
         header($location);
         exit;
      }
      break;
}

// Czy zmieinono zawartosc koszyka? Jesli tak, to wyzeruj numer order_id, o ile takowy jest zapamietany w sesji
// sytuacja, kiedy np. po przejsciu do autoryzacji kart, ktos wraca do sklepu i zmienia zawartsoc ksozyka
// w takiej sytuacji traktujemy to jako nowa transakcje, dlatego wyzerowujemy order_id. Dzieki temu przy
// reallizacji zamowienia zostanie wygenerowany nowy numer order_id.
if ($basket_change==true) {
    $sess->unregister("global_order_id");
    $sess->unregister("global_order_id_date");
}

// oblicz koszty dostawy
$basket->calc_delivery();

$global_basket_calc_button=true; // pokaz przycisk podsumuj pod zawartoscia koszyka

// zapamietaj wywolanie tej strony
$global_lock_basket=true;
$sess->register("global_lock_basket",$global_lock_basket);

// jesli wczesniej byly zapamietane wywolania register i send, to anuluj je
$global_lock_register=false;
$global_lock_send=false;
$sess->register("global_lock_register",$global_lock_register);
$sess->register("global_lock_send",$global_lock_send);

if ($all_done == true)
{
   $global_lock_register=true;
   $sess->register("global_lock_register",$global_lock_register);
   if (!empty($_POST['payment']))
   {
      $sess->register("form",$form);
      $sess->register("form_cor",$form_cor);
      $sess->register("payment",$_POST['payment']);
      Header( "HTTP/1.1 301 Moved Permanently" );
      //Header( "Location: /go/_basket/register3.php");
      Header( "Location: /koszyk-gotowe");
   }
   die ("Blêdne okreslenie metody platnosci");
   $theme->go2main();
   exit;
}
else
{
   if (strlen($_SESSION['global_login']) == 0) 
   {
      if (! empty($_SESSION['form_try'])) 
      {
         $form = $_SESSION['form_try'];
         $form_check->form=&$form;
      }
      if (! empty($_SESSION['form_cor'])) 
      {
         $form_cor = $_SESSION['form_cor'];
         $form_check->form_cor=&$form;
      }
   }
   else
   {
      if (! empty($_SESSION['form'])) 
      {
         $form=$_SESSION['form'];
         //$form_check->form=&$form; // przekaz dane z formularza
      }
   }
     
   //ok sprawdzamy czy zostal wywolany koszyk. Jesli tak to przepisujemy URLa
   if (ereg("^/go/_basket/index.php$",$_SERVER['SCRIPT_URL']))
   {
      $sess->register("current_step",$display_step);
      switch ($display_step)
      {
         case 1:
            Header( "HTTP/1.1 301 Moved Permanently" );
            Header( "Location: /koszyk-start" );
            break;
            
         case 2:
            Header( "HTTP/1.1 301 Moved Permanently" );
            Header( "Location: /koszyk-dane" );
            break;
            
         default:
            Header( "HTTP/1.1 301 Moved Permanently" );
            Header( "Location: /koszyk-start" );
            break;
      }
   }
   
   //$theme->head();
  
   if ($display_step==2)
   {
      $sess->register("current_step",$display_step);
      //$theme->action="/go/_basket/index.php?action=form_check#forms"; 

      $theme->action="/koszyk-dane/action=form_check#forms"; 
      $my_basket->display="text";    // bez elementow formularza
      $theme->page_open_object("show_form",$my_basket,"page_open_simple_step_2");
      $theme->show_order_step_two($form,$form_check);
      $theme->foot();
   }
   else
   {
      //W zaleznosci od kroku wyswietlany odpowiedni napis
     $theme->page_open_object("show_form",$my_basket,"page_open_2");
   }
   
   $sess->unregister("disable_ajax");
   //$theme->foot();
   //include_once ("include/foot.inc");
}
?>
