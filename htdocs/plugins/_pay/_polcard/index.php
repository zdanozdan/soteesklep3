<?php
/**
* Przej¶cie na strone autoryzacji PolCard.
*
* Skrypt ten wy¶wietla formularz HTML przekierowuj±cy klienta na stronê PolCardu.
* Wywo³anie tego skryptu jest odnotowywane w bazie poprzez dodania wpisu transakcji z odpowiednim statusem
* (id_pay_method=3).
*
* @author m@sote.pl
* @version $Id: index.php,v 1.9 2005/02/10 13:11:51 lechu Exp $
* @package    pay
* @subpackage polcard
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
@include_once ("../../../../include/head.inc");
@include_once ("config/auto_config/polcard_config.inc.php");

// start sprawdz: czy polcard jest wlaczony w sklepie
if ($polcard_config->active!=1) {
    // naglowek
    $theme->head();
    $theme->page_open_head("page_open_1_head");
    
    $theme->theme_file("_polcard/polcard_info.html.php");
    
    // stopka
    $theme->page_open_foot("page_open_1_foot");
    $theme->foot();
    include_once ("include/foot.inc");
    exit;
}
// end sprawdz:

// klasa funckji zwiazanych z polcardem - inicjacja obiektu $polcard
require_once("$DOCUMENT_ROOT/plugins/_pay/_polcard/include/polcard.inc.php");

if (! empty($_SESSION['global_basket_data'])) {
    require_once ("go/_basket/include/my_basket.inc.php");
    $basket=& new MyBasket;
    $my_basket=&$basket;
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

$polcard = new PolCard;
$polcard->pos_id=$polcard_config->posid;
$polcard->order_id=$order_id;

// cena standardowa
$polcard->amount=$polcard->price($_SESSION['global_order_amount']);

// zmiana ceny z uwzglednieniem promocji _promotions
require_once ("include/price.inc");
$my_price = new MyPrice;
$shop->basket();
$polcard->amount=$polcard->price($my_price->promotionsAmount($shop->basket->totalAmount()));
// end

$polcard->email=$form['email'];
$polcard->client_ip=$_SERVER['REMOTE_ADDR'];
$polcard->street=$form['street'];
$polcard->street_n1=$form['street_n1'];
$polcard->street_n2=$form['street_n2'];
$polcard->phone=$form['phone'];
$polcard->city=$form['city'];
$polcard->postcode=$form['postcode'];

// sprawdz status
if ($polcard_config->status==1) {
    $polcard->test="N";
} else $polcard->test="Y";

// ustaw jezyk systemu komunikacji PolCard z klientem
if ($config->lang=="pl") {
    $polcard->language="PL";
} else $polcard->language="EN";

$theme->theme_file("_polcard/polcard_before.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
