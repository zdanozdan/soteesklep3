<?php
/**
 * PHP Template:
 * Lokalna definicja lang
 * 
 * @author m@sote.pl
 * @template_version Id: lang.inc.php,v 2.1 2003/03/13 11:29:04 maroslaw Exp
 * @version $Id: lang.inc.php,v 1.5 2003/04/30 07:47:08 piotrek Exp $
 * @package soteesklep
 */

//# $lang->nazwa="wartosc";
$lang->reviews_bar="reviews";

// dodanie rekordu
$lang->reviews_add_bar="Twoja ocena produktu";
$lang->reviews_record_add="Rekord dodany";

// aktualizacja rekordu
$lang->reviews_update_bar="Aktualizacja rekordu";
$lang->reviews_edit_update_ok="Rekord zaktualizowany";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->reviews_form_errors=array("score"=>"Brak oceny");

// nazwy kolumn do formularza, nazwy pojawia sie przy wyswietleniu pol formularza
$lang->reviews_cols=array("id_product"=>"nazwa 1",
                          "text"=>"nazwa 2",
                          "description"=>"Recenzja",
                          "score"=>"Ocena",
                          "author"=>"Autor"
                          );

$lang->reviews_menu=array("add"=>"Dodaj",
                          "list"=>"Lista");
$lang->reviews_list_bar="Lista rekordow";

$lang->reviews_info="Recenzja produktu: ";

$lang->reviews_no_product="Niestety Twoja recenzja nie zosta³a wys³ana. Przepraszamy.";

$lang->reviews_send_ok="Twoja recenzja zosta³a wys³ana. Dziêkujemy.";

$lang->reviews_send_ok_again="Twoja recenzja ju¿ zosta³a wys³ana. Mo¿esz oceniæ inny produkt :-)";

$lang->reviews_close="Zamknij";

$lang->reviews_send="Wy¶lij";

$lang->edit_submit="Wy¶lij";

$lang->reviews_anonymous="Anonimowy";

?>