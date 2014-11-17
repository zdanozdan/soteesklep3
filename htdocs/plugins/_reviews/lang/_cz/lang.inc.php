<?php
/**
 * PHP Template:
 * Lokalna definicja lang
 * 
 * @author m@sote.pl
 * @template_version Id: lang.inc.php,v 2.1 2003/03/13 11:29:04 maroslaw Exp
 * @version $Id: lang.inc.php,v 1.1 2005/02/11 14:18:29 krzys Exp $
 * @package soteesklep
 */

//# $lang->nazwa="wartosc";
$lang->reviews_bar="reviews";

// dodanie rekordu
$lang->reviews_add_bar="Tvé hodnocení produktu";
$lang->reviews_record_add="Rekord dodany";

// aktualizacja rekordu
$lang->reviews_update_bar="Aktualizace rekordu";
$lang->reviews_edit_update_ok="Aktualizovaný rekord";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->reviews_form_errors=array("score"=>"Chybí hodnocení");

// nazwy kolumn do formularza, nazwy pojawia sie przy wyswietleniu pol formularza
$lang->reviews_cols=array("id_product"=>"název 1",
                          "text"=>"název 2",
                          "description"=>"Recenze",
                          "score"=>"Hodnocení",
                          "author"=>"Autor"
                          );

$lang->reviews_menu=array("add"=>"Pøidej",
                          "list"=>"Seznam");
$lang->reviews_list_bar="Seznam rekordù";

$lang->reviews_info="Recenze produktu: ";

$lang->reviews_no_product="Bohu¾el Tvá recenze nebyla odeslána. Omlouváme se.";

$lang->reviews_send_ok="Tvá recenze byla odeslána. Dìkujeme.";

$lang->reviews_send_ok_again="Tvá recenze ji¾ byla odeslána. Mù¾e¹ ohodnotit jiný produkt :-)";

$lang->reviews_close="Zavøi";

$lang->reviews_send="Po¹li";

$lang->edit_submit="Po¹li";

$lang->reviews_anonymous="Anonymní";

?>