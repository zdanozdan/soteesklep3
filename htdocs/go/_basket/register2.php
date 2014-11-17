<?php
/**
* Wywolanie podsumowania zamowienia, wybor rodzaju platnosci
*
* @require bool $global_lock_register=true konieczne wczesniejsze wywolanie formularza zamowienia
*
* @author m@sote.pl
* @version $Id: register2.php,v 1.1 2006/11/23 17:57:58 tomasz Exp $
* @package    register
*/

// Jesli w sesji zapisany jest obiekt, to klasa tego obiektu,
// musi byc zaladowana przed otworzeniem sesji!
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}

$global_database=true;
include_once ("../../../include/head.inc");

// naglowek
if(empty($__open_head)){
    $theme->head();
    $theme->page_open_head("page_open_1_head");
}

// sprawdz, czy wczesniej wywolano strone z formularzem zmowienia
if (my(@$_SESSION['global_lock_register'])!=true) {
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

$points_ok=true;
if ($basket->mode=="points") {
	$points_ok=false;
	require_once("./include/points.inc.php");
	$points_get=& new UserPoints();
	// punkty z bazy danych
	$my_points=$points_get->show_user_points($_SESSION['global_id_user']);
	$form=$_SESSION['form'];
	// punkty z sesji
	$points_reserved=$form['points_reserved'];
	// sprawdzamy czy jest do¶æ punktów na koncie u¿ytkownika
	if ($my_points-$points_reserved>=0) $points_ok=true;
}

if (! empty($_SESSION['global_delivery'])) {
    $global_delivery=$_SESSION['global_delivery'];
} else $global_delivery="";

if (! empty($_SESSION['global_order_amount'])) {
    $global_order_amount=$_SESSION['global_order_amount'];
} else if (! empty($_SESSION['form']['points_reserved'])) {
	$global_order_points_reserved=$_SESSION['form']['points_reserved'];
} else $theme->go2main();

// odczytaj dane z sesji z wczesniej wypelnionych formularzy
if (! empty($_SESSION['form'])) {
    $form=&$_SESSION['form'];
}
if (! empty($_SESSION['form_cor'])) {
    $form_cor=&$_SESSION['form_cor'];
}

// sprawdz czy nie ? nowych danych w formularzu HTML
// dane te moga byc inne niz dane zapisane w sesji, dane w sesji moga np. pochodzic
// z bazy, a teraz klient moze wpisac cos innego, lub np. nie wprowadzil jakis danych przy rejestracji
// np. NIPu itp.
if (! empty($_POST['form'])) {
    $form=&$_POST['form'];
}
if (! empty($_POST['form_cor'])) {
    $form_cor=&$_POST['form_cor'];
}

// Wyswietl zawartosc koszyka
if ($basket->mode=="points" && !$points_ok) {
	$my_basket->error(202);
	$form['points']=$my_points;
	$sess->register("form",$form);
}
$my_basket->display="text";    // bez elementow formularza
$my_basket->show_form();

$theme->register_confirm_limited($form,$form_cor);  // podsumowanie - dane z formularzy

if (! $my_basket->isEmpty()) {
    if ($basket->mode=="standard") {
		$theme->basket_amount($my_basket->amount,$global_order_amount,$global_delivery['name'],$global_delivery['cost']);
	} elseif ($basket->mode=="points" && $points_ok) {
		$theme->basket_points_amount($my_basket->amount,$global_order_amount,$global_delivery['name'],$global_delivery['cost']);
	} else {
		$my_basket->emptyBasket();
		$theme->go2main(10);
		exit;
	}    

    $theme->register_pay_method();              // wybor platnosci
}
$theme->page_open_foot("page_open_1_foot");


// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
