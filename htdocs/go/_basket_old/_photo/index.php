<?php
/**
 * Za³±czanie zdjêæ i opisów do zamówienia. Skryt wywo³ywany w URL.
 *
 * \@require bool $global_lock_basket=true konieczne wczesniejsze wywolanie koszyka _basket
 * \@session strong $global_order_ext_description dodatkowy opis zamowienia
 *
 * @author m@sote.pl
 * @version $Id: index.php,v 2.6 2006/02/09 10:33:05 maroslaw Exp $
 * @package    basket
 * @subpackage photo
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");

/**
* Obs³uga wy¶wietlania formatki do zdjêæ.
*/
require_once ("./include/basket_photo.inc.php");


// sprawdz, czy wczesniej wywolano strone z koszykiem
if (my(@$_SESSION['global_lock_basket'])!=true) {
    // wyswietl strone z linkiem do glownej strony
    //print "<html><body onload=\"window.close();\"></body></html>\n";
    print "<pre>";print_r($_SESSION);print "</pre>";
    exit;
}

if (! empty($_SESSION['global_order_amount'])) {
    $global_order_amount=$_SESSION['global_order_amount'];    
} elseif (empty($global_order_amount)) {                   // zmieniono ilsoc produktow i wcisnieto zamaiwam, a nie podsumuj
    die ("Bledne wywolanie");
}

// dodatkowe funkcje obslugi koszyka, funkcja wyswietlenia zawartosci koszyka:
// klasa: ShowBasket, funkcja: show_form()
require_once ("../include/my_basket.inc.php");
$basket =& new MyBasket();
$my_basket=&$basket;          // UWAGA! przypisanie wska¿nika adresu jest wymagane do poprawnego dzia³ania koszyka

// naglowek
$theme->theme_file("head_simple.html.php");
$theme->page_open_head("page_open_1_head");

// sprawdz, czy zostal juz zainicjowany koszyk; jesli nie to nie zezwalaj na
// wprowadzenie danych
if (empty($_SESSION['my_basket']) && (! is_object($my_basket))) {   
    exit;
}

// saksuj wybrane zdjecie
if (! empty($_REQUEST['com'])) {
    $com=$_REQUEST['com'];
}
if (! empty($com)) {
    if ($com=="delete") {
        if ((! empty($_REQUEST['user_id'])) && (! empty($_REQUEST['name']))) {
            $basket_photo->delete($_REQUEST['user_id'],$_REQUEST['name']);
        }
    } else die ("Bledne wywolanie");
}

// sprawdz, czy zostalo zalaczone jakies zdjecie
if ($basket_photo->test_upload()==true) {
    // dodaj wpis dot. zdjecia do bazy, wstaw zdjecie do ./tmp_photos
    $basket_photo->insert_update();
}
// sprawdz czy nie wybrano nazwy z listy juz zalaczonych plikow
$basket_photo->select_name();

// sprawdz czy dodano jakies opisy zamowienia
if (! empty($_POST['basket_photo_description'])) {
    $global_basket_photo_description=$_POST['basket_photo_description'];
    // zapisz opisy w sesji
    $sess->register("global_basket_photo_description",$global_basket_photo_description);
} elseif (! empty($_SESSION['global_basket_photo_description'])) {
    $global_basket_photo_description=$_SESSION['global_basket_photo_description'];
}

$theme->theme_file("basket_photo.html.php");
$basket_photo->form_list();

if (! empty($basket_photo->form_order_description)) {
    // dodatkowy opis zamowienia
    $global_order_ext_description=$basket_photo->form_order_description;
    $sess->register("global_order_ext_description",$global_order_ext_description);
}

// stopka
$theme->page_open_foot("page_open_1_foot");
$theme->theme_file("foot_simple.html.php");
include_once ("include/foot.inc");
?>
