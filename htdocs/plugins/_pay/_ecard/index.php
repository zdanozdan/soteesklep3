<?php
/**
* Przejscie na strone aytoryzacji eCard
*
* @author m@sote.pl
* @version $Id: index.php,v 1.4 2005/01/20 15:00:28 maroslaw Exp $
* @package    pay
* @subpackage ecard
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../../include/head.inc");
require_once ("go/_basket/include/my_basket.inc.php");

// klasa funckji zwiazanych z eCardem - inicjacja obiektu $ecard
require_once("$DOCUMENT_ROOT/go/_register/_ecard/include/ecard.inc.php");

if (! empty($_SESSION['my_basket'])) {
    $my_basket=$_SESSION['my_basket'];
    $my_basket->display="text";
}

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

// sprawdz, czy zostal juz zainicjowany koszyk; jesli nie to nie zezwalaj na
// wprowadzenie danych
if (empty($_SESSION['my_basket']) && (! is_object($my_basket))) {
    exit;
}

// dane zmawiajacego (billing)
if (! empty($_SESSION['form'])) {
    $form=$_SESSION['form'];
} else die ("Bledne dane");

// dane korespondencyjne
if (! empty($_SESSION['form_cor'])) {
    // adres koresponccyjny
    $form_cor2=$_SESSION['form_cor'];
} else {
    // kopia adresu bilingowego jako adres korespondencyjny
    $form_cor2=$form;
}

// odczytaj order_id
if (! empty($_SESSION['global_order_id'])) $order_id=$_SESSION['global_order_id'];
if ((empty($order_id)) && (! empty($global_order_id))) $order_id=$global_order_id;

$ecard = new eCard;
$ecard->urlpost=$config->ecard_servlet;
$ecard->ORDERNUMBER=$order_id;
$ecard->AMOUNT=$ecard->price($_SESSION['global_order_amount']);
$ecard->NAME=$form['name'];
$ecard->SURNAME=$form['surname'];
$ecard->ORDERDESCRIPTION=$ecard->order_description($my_basket);
$ecard->SESSIONID=$sess->id;

$theme->theme_file("_ecard/ecard_before.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
