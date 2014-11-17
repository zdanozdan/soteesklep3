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
$lang->reviews_add_bar="Tv� hodnocen� produktu";
$lang->reviews_record_add="Rekord dodany";

// aktualizacja rekordu
$lang->reviews_update_bar="Aktualizace rekordu";
$lang->reviews_edit_update_ok="Aktualizovan� rekord";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->reviews_form_errors=array("score"=>"Chyb� hodnocen�");

// nazwy kolumn do formularza, nazwy pojawia sie przy wyswietleniu pol formularza
$lang->reviews_cols=array("id_product"=>"n�zev 1",
                          "text"=>"n�zev 2",
                          "description"=>"Recenze",
                          "score"=>"Hodnocen�",
                          "author"=>"Autor"
                          );

$lang->reviews_menu=array("add"=>"P�idej",
                          "list"=>"Seznam");
$lang->reviews_list_bar="Seznam rekord�";

$lang->reviews_info="Recenze produktu: ";

$lang->reviews_no_product="Bohu�el Tv� recenze nebyla odesl�na. Omlouv�me se.";

$lang->reviews_send_ok="Tv� recenze byla odesl�na. D�kujeme.";

$lang->reviews_send_ok_again="Tv� recenze ji� byla odesl�na. M��e� ohodnotit jin� produkt :-)";

$lang->reviews_close="Zav�i";

$lang->reviews_send="Po�li";

$lang->edit_submit="Po�li";

$lang->reviews_anonymous="Anonymn�";

?>