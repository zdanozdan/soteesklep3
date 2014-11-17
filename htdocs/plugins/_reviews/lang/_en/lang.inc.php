<?php
/**
 * PHP Template:
 * Lokalna definicja lang plugins/_reviews
 * 
 * @author piotrek@sote.pl
 * @version $Id: lang.inc.php,v 1.1 2003/07/16 13:18:55 piotrek Exp $
 * @package soteesklep
 */

//# $lang->nazwa="wartosc";
$lang->reviews_bar="Reviews";

// dodanie rekordu
$lang->reviews_add_bar="Scoring product";
$lang->reviews_record_add="Record has been added";

// aktualizacja rekordu
$lang->reviews_update_bar="Aktualizacja rekordu";
$lang->reviews_edit_update_ok="Rekord zaktualizowany";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->reviews_form_errors=array("score"=>"No score");

// nazwy kolumn do formularza, nazwy pojawia sie przy wyswietleniu pol formularza
$lang->reviews_cols=array("id_product"=>"nazwa 1",
                          "text"=>"nazwa 2",
                          "description"=>"Review",
                          "score"=>"Score",
                          "author"=>"Author"
                          );

$lang->reviews_menu=array("add"=>"Add",
                          "list"=>"List");
			  
$lang->reviews_list_bar="Lista rekordow";

$lang->reviews_info="Review of the product: ";

$lang->reviews_no_product="Unfortunately, your review has not been sent. We are sorry.";

$lang->reviews_send_ok="Your review has been sent. Thank you.";

$lang->reviews_send_ok_again="Your review regarding this product has been already sent.<BR> You can score another product :-)";

$lang->reviews_close="Close";

$lang->reviews_send="Send";

$lang->edit_submit="Send";

$lang->reviews_anonymous="Anonymous";

?>