<?php
/**
* Formularz zamownienia, dane billingowe                               |
*
* @require bool $global_lock_basket=true konieczne wczesniejsze wywolanie koszyka _basket
* \@session array $form dane z formularza billingowego
*
* @author m@sote.pl
* @version $Id: index.php,v 1.2 2006/11/29 22:43:57 tomasz Exp $
* @package    register
*/

/**
* Oznaczenie tej zmiennej na true powoduje niezerowanie zmiennej $basket_add_lock w sesji.
* Je¶li $__basket_add_lock!=true to odblokowywana jest mo¿liwo¶æ dodania do koszyka. 
* Wykorzystanie w/w zmiennej zabezpiecza przed ziêkszeniem ilo¶ci produktów w koszyku
* po wywo³aniu przycisku "BACK" w przegl±darce na stronie danych bilingowych.
* Zmienna zapisana w sesji $basket_add_lock jest zerowana w include/head.inc
*/ 
$__basket_add_lock=true;

// Jesli w sesji zapisany jest obiekt, to klasa tego obiektu,
// musi byc zaladowana przed otworzeniem sesji!
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
	$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
}



$global_database=true;
$global_secure_test=true;
include_once ("../../../include/head.inc");
global $_SESSION;
// sprawdz, czy wczesniej wywolano strone z koszykiem
if (my(@$_SESSION['global_lock_basket'])!=true) {
	// wyswietl strone z linkiem do glownej strony
	$theme->go2main();
	exit;
}

if (! empty($_SESSION['global_basket_data'])) {
	require_once ("go/_basket/include/my_ext_basket.inc.php");
	$basket=& new My_Ext_Basket();
	$basket->init();
	$my_basket=&$basket;
	$my_basket->display="text";
}

if (! empty($_SESSION['global_delivery'])) {
	$global_delivery=$_SESSION['global_delivery'];
} else $global_delivery="";

if (!empty($_SESSION['form']['points_reserved'])) {
	$global_order_points=$_SESSION['form']['points_reserved'];
}
if (! empty($_SESSION['global_order_amount'])) {
	$global_order_amount=$_SESSION['global_order_amount'];
} elseif (empty($global_order_amount) && empty($global_order_points)) {                   // zmieniono ilsoc produktow i wcisnieto zamaiwam, a nie podsumuj
$theme->go2main();
}

// naglowek
if(empty($__open_head)){
   $val = true;
   $sess->register("head_display",$val);
   $theme->head();
   $theme->page_open_head("page_open_1_head");
}
// sprawdz, czy zostal juz zainicjowany koszyk; jesli nie to nie zezwalaj na
// wprowadzenie danych
if (empty($_SESSION['my_basket']) && (! is_object($my_basket))) {
	exit;
}

// klasa obslugujaca sprawdzanie poprawnosci formularzy HTML
include_once ("include/form_check.inc");
include_once ("./include/my_form_check.inc.php");
$form_check = new MyFormCheck;

// odczytaj parametry przekazane z formularza HTML
// ktore sa zapisane w tablicy form
if (! empty($_POST['form'])) {
	$form=$_POST['form'];
	if (!empty($_SESSION['form'])) {
		$form1=$_SESSION['form'];
		$form=array_merge($form1,$form);
	}
	$form_check->form=&$form; // przekaz dane z formularza
}
// definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
// (z klasy FormCheck)
$form_check->fun['firm']="null";
$form_check->fun['name']="string";
$form_check->fun['surname']="string";
$form_check->fun['street']="string";
$form_check->fun['street_n1']="string";
$form_check->fun['street_n2']="null";
$form_check->fun['postcode']="string";
$form_check->fun['city']="string";
$form_check->fun['phone']="string";
$form_check->fun['email']="users_email";
$form_check->fun['nip']="nip";
$form_check->fun['news']="yes";
$form_check->fun['description']="null";
$form_check->fun['cor_addr']="null";
$form_check->fun['country']="country";

// sprawdz czy jest to wywolanie wyswietlenia formularza, czy sprawdzenie
if (! empty($form['check'])) {
	$form_check->check=my($form['check']);
}
global $lang;
// tablica z komunikatami bledow
$form_check->errors=$lang->register_billing_form_errors;

// sprawdz czy formularz jest poprawnie wyswietlony
// wymagane sa pola, ktore maja odpowiednia wartosc w $form_check->errors
// tj. maja przypisany komunikat o bledzie
// foreach ( $_POST as $key=>$val ) {
//    print "klucz:$key, value:$_POST[$key]\n    ";
//    $v = $_POST[$key];
//    foreach ( $v as $key1=>$va1l ) {
//       print "klucz:$key1, value:$v[$key1]\n    ";
//    }   
// }

// if (isset($_POST['current_step']))
// {
//    $val = $_POST['current_step'];
//    $theme->display3steps($val);
// }

if ($form_check->check=="true") 
{
   if ($form_check->form_test()) 
   {
      $theme->display3steps(3);
      // poprawnie wypeniony formularz
      
      // spraedz czy wybrano wprodwadzenie adresu korespondencyjnego
      if ($form['cor_addr']=="no") {
         // tak
         $sess->register("form",$form);
         $__open_head=true;
         include_once ("register1.php");
      } else {
         // nie
         $sess->register("form",$form);
         $__open_head=true;
         include_once ("register2.php");
      }
      exit;
   }
}
$theme->display3steps(2);
// Wyswietl zawartosc koszyka
$my_basket->display="text";    // bez elementow formularza
$my_basket->show_form();
if (! $my_basket->isEmpty()) 
{
   if ($basket->mode=="standard") 
   {
      $theme->basket_amount($my_basket->amount,$global_order_amount,$global_delivery['name'],$global_delivery['cost']);
   } 
   elseif ($basket->mode=="points") 
   {
      $theme->basket_points_amount($my_basket->amount,@$global_order_amount,$global_delivery['name'],$global_delivery['cost']);
   } 
   else 
   {
      $theme->go2main();
   }

   // wyswietl ponownie formularz, jesli zostal zle
   // wypelniony (lub jesli jest to pierwsze wywolanie)
   // w przypadku zlego wypelnienia, dodaj komunikaty o bledach
   // zawarte (po sprawdzeniu formularza) w tablicy $form_check->errors_found
   // sprawdz, czy user sie nie zarejstrowal wczesniej, wtedy w sesji beda dane uzytkownika $form (i $form_cor)
   if (! empty($_SESSION['form'])) 
   {
      $form=$_SESSION['form'];
   }
   
   $theme->action="/go/_register/index.php"; 
   $theme->register_billing_form_nomenu($form,$form_check);
   

	global $global_lock_register;
	// zapamietaj wywolanie tej strony
	$global_lock_register=true;
	$sess->register("global_lock_register",$global_lock_register);
}
$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
