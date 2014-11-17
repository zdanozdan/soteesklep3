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
*
* @author  m@sote.pl
* @version $Id: index.php,v 1.6 2006/11/30 19:42:26 tomasz Exp $
* @package    basket
*/

// blokada przed back z formularza zamówienia
$__basket_add_lock=true;

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu
*/


require_once ("../../../include/head.inc");

// print("<table border=2>");
// for($j=0;$j<count($HTTP_SERVER_VARS);$j++)
// {
//    $row = each($HTTP_SERVER_VARS);
//    print "<tr><td>" . $row["key"] . "<td>" . $row["value"];
// }
// print("</table>");

//echo $HTTP_SERVER_VARS['HTTP_REFERER'];

$http_referer = $HTTP_SERVER_VARS['HTTP_REFERER'];

$val = true;
$sess->register("head_display",$val);

/**
* czy za³adowaæ nowy (obiektowy) koszyk
*/
if (@$config->new_basket) {
   include ("./index2.php");
   die ();
}
/**
* Obs³uga opcji zaawansowanych dot. produktu
* @ignore
*/
require_once ("./include/basket_options.inc.php");

/**
* Dodatkowe funkcje obslugi koszyka, funkcja wy¶wietlenia zawarto¶ci koszyka:
* klasa: ShowBasket, funkcja: show_form()
*/
require_once ("./include/my_basket.inc.php");
$basket =& new MyBasket();
$my_basket=&$basket;          // UWAGA! przypisanie wska¿nika adresu jest wymagane do poprawnego dzia³ania koszyka

/**
* Klasa funckji: oblicz koszty dostawy, wy¶wietl listê dostawców itp.
*/
require_once("./include/delivery.inc.php");

// odczytaj numer id produktu, ktory jest dodawany do koszyka
// jesli id nie jest puste, to produkt jest dodawany do ksozyka,
// w przeciwnym razie przedstawiany jest tylko status koszyka
$id="";
if (!empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
}

// odczytaj wybranego dostawce, o ile user wybral zmiane dostawcy
if (! empty($_REQUEST['delivery'])) {
    $delivery=$_REQUEST['delivery'];
} else $delivery=array();

if (! empty($_SESSION['global_delivery'])) {
    $global_delivery=$_SESSION['global_delivery'];
}

/**
* Sprawdz jaki jest rodzaj wywolania skryptu.
* Czy jest to dodanie do koszyka, update koszyka, czy przejscie dalej do formularza z danymi
* itp.
*/
$submit_type="";
if (! empty($_POST['submit_update'])) {
    $submit_type="update";  // podlicz
}
if (! empty($_POST['submit_proceed'])) {
    $submit_type="proceed"; // dalej
}
if (! empty($_POST['del'])) {
    $submit_type="delete";  // kasuj wybrany produkt
}
if ((empty($submit_type)) && (! empty($id))) {
    $submit_type="add";
}

$basket_change=false;
switch ($submit_type) {
    case "update":
    $basket_change=true;
    include_once("include/basket_update.inc.php");
    break;
    case "delete":
    $basket_change=true;
    include_once("include/basket_update.inc.php");
    break;
    case "proceed":
    include_once("include/basket_update.inc.php");
    /* zapisz dane koszyka w sesji */
    $basket->calc();
    $basket->register();

    // oblicz koszty dostawy
    // #505 local
    $delivery_obj->calc();
    global $global_delivery;
    $global_delivery=array();
    $global_delivery['id']=$delivery_obj->delivery_id;
    $global_delivery['name']=$delivery_obj->delivery_name;
    $global_delivery['cost']=$theme->price($delivery_obj->delivery_cost);
    $global_delivery['pay']=$delivery_obj->delivery_pay;
    $sess->register("global_delivery",$global_delivery);
    /**
    * Zapisz dane koszyka w sesji 
    * Dane s± zapisuwane przed head(), gdy¿ s± one wykorzystywane m.in. do pokazania ilo¶ci produktów w koszyku itp.
    * w nag³ówku.
    */
    $basket->register();
    // end #505 local

    // wywolaj nowy skrypt
    include_once("go/_register/index.php");
    // zakoncz dzialanie tego skryptu
    exit;
    break;
    case "add":
    $basket_change=true;
    include_once("./include/basket_add.inc.php");
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
$delivery_obj->calc();
global $global_delivery;
$global_delivery=array();
$global_delivery['id']=$delivery_obj->delivery_id;
$global_delivery['name']=$delivery_obj->delivery_name;
$global_delivery['cost']=$theme->price($delivery_obj->delivery_cost);
$global_delivery['pay']=$delivery_obj->delivery_pay;
$sess->register("global_delivery",$global_delivery);

/**
* Zapisz dane koszyka w sesji 
* Dane s± zapisuwane przed head(), gdy¿ s± one wykorzystywane m.in. do pokazania ilo¶ci produktów w koszyku itp.
* w nag³ówku.
*/
$basket->register();

// naglowek
$theme->head();

$global_basket_calc_button=true; // pokaz przycisk podsumuj pod zawartoscia koszyka

$theme->page_open_object("show_form",$my_basket,"page_open_2");

// zapamietaj wywolanie tej strony
$global_lock_basket=true;
$sess->register("global_lock_basket",$global_lock_basket);

// jesli wczesniej byly zapamietane wywolania register i send, to anuluj je
$global_lock_register=false;
$global_lock_send=false;

$sess->register("global_lock_register",$global_lock_register);
$sess->register("global_lock_send",$global_lock_register);

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
