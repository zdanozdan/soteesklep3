<?php
/**
* Zawarto¶æ koszyka.
* Przedstawienie stanu koszyka, podliczenie zawartosci, dodanie produktu do koszyka, wybor dostawcy towaru. <br>
* <br /><br />
* \@session real $global_basket_amount warto¶æ zamówienia, bez kosztów dostawy<br />
* \@session int  $global_basket_count ilo¶æ produktów w koszyku<br />
* \@session bool $global_lock_register=false nie zezwalaj na przej¶cie do wys³ania zamówienia bez przej¶cia przez strone _register<br />
* \@session bool  $global_lock_send=false zezwalaj na wyslanie zamowienia w tej sesji<br />
* \@session array $global_basket_data dane koszyka<br />
* \@session array $global_wishlist_data dane przechowalni<br />
*
* @author  lukasz@sote.pl
* @version $Id: index3.php,v 1.2 2006/11/29 22:43:57 tomasz Exp $
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

/**
* Obs³uga opcji zaawansowanych dot. produktu
* @ignore
*/
/**
* Dodatkowe funkcje obslugi koszyka, funkcja wy¶wietlenia zawarto¶ci koszyka:
* klasa: ShowBasket, funkcja: show_form()
*/

// nowy koszyk
/**
* Nowy koszyk - klasa My_Ext_Basket, obs³uga produktów, wy¶wietlanie ich listy, modyfikacja tej listy, zapis danych w sesji, bazie danych i pliku cookie - itp.
*/
require_once("./include/my_ext_basket.inc.php");

$basket=& new My_Ext_Basket();
$wishlist=& new My_Ext_Basket('wishlist');
$my_wishlist=& $wishlist;
// tworzymy relacje miêdzy jednym a drugim
$basket->_move_target=&$wishlist;
$wishlist->_move_target=&$basket;
// inicjujemy - ³adujemy informacje z bazy/sesji
$wishlist->init();
$basket->init();
// end nowy koszyk

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
// tworzymy tablice nowych ilo¶ci produktów (je¿eli s± one ustawione)
if (empty($id) && isset($_POST['num'])) {
	foreach ($_POST['num'] as $int_id => $val) {
		$num[] = array( $int_id => "$val");
	}
}

// przypisujemy odpowiedni± warto¶æ do wewnêtrznego id usuwanego produktu
if (empty($id) && isset($_POST['del'])) {
	foreach ($_POST['del'] as $int_id => $val) {
		$del[] = array( $int_id => "$val");
	}
}
// przypisujemy odpowiedni± warto¶æ do wewnêtrznego id przenoszonego produktu
if (empty($id) && isset($_POST['move'])) {
	foreach ($_POST['move'] as $int_id => $val) {
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
global $submit_type;
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
if (!empty($_POST['move'])) {
	$submit_type="move"; // przenie¶ do koszyka
}
if ((empty($submit_type)) && (! empty($id))) {
	$submit_type="add";
}

// po ka¿dym dzia³aniu aktualizujemy sesje przechowalni - aby unikn±æ podwójnej rejestracji
$basket_change=false;
switch ($submit_type) {
	case "move":
	$basket_change=true;
	$wishlist->move_many_prod($move);
	// tutaj nie rejestrujemy przechowalni - odbywa siê to podczas aktualizacji produktów w basket_update
	$basket->register();
	break;
	case "update":
	$basket_change=true;
	$wishlist->update_many($num);
	$wishlist->_save_to_db();
	$wishlist->register();
	break;
	case "delete":
	$basket_change=true;
	$wishlist->del_many_prod($del);
	$wishlist->register();
	break;
	case "add":
           if ($wishlist->check_options($id,@$num,$options,$basket_cat,$ext_basket) == false)
           {
              $basket_change=true;
              $wishlist->add_prod($id,@$num,$options,$basket_cat,$ext_basket);
              $wishlist->register();
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


/**
* Zapisz dane koszyka w sesji 
* Dane s± zapisuwane przed head(), gdy¿ s± one wykorzystywane m.in. do pokazania ilo¶ci produktów w koszyku itp.
* w nag³ówku.
*/
// naglowek
$theme->head();

$global_basket_calc_button=true; // pokaz przycisk podsumuj pod zawartoscia koszyka
$theme->page_open_object("show_form",$my_wishlist,"page_open_2");

// zapamietaj wywolanie tej strony
$global_lock_basket=true;
$sess->register("global_lock_basket",$global_lock_basket);

// jesli wczesniej byly zapamietane wywolania register i send, to anuluj je
$global_lock_register=false;
$global_lock_send=false;
$sess->register("global_lock_register",$global_lock_register);
$sess->register("global_lock_send",$global_lock_register);
/*
*/// stopka
$theme->foot();
include_once ("include/foot.inc");

?>
