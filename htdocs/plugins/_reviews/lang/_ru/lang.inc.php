<?php
/**
 * PHP Template:
 * Lokalna definicja lang
 * 
 * @author m@sote.pl
 * @template_version Id: lang.inc.php,v 2.1 2003/03/13 11:29:04 maroslaw Exp
 * @version $Id: lang.inc.php,v 1.2 2005/04/11 09:05:26 krzys Exp $
 * @package soteesklep
 */

//# $lang->nazwa="wartosc";
$lang->reviews_bar="reviews";

// dodanie rekordu
$lang->reviews_add_bar="Tвоя точка зрения о продукте";
$lang->reviews_record_add="екорд добавлен";

// aktualizacja rekordu
$lang->reviews_update_bar="Корректировка рекорда";
$lang->reviews_edit_update_ok="Рекорд скорректирован";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->reviews_form_errors=array("score"=>"Брак мнения");

// nazwy kolumn do formularza, nazwy pojawia sie przy wyswietleniu pol formularza
$lang->reviews_cols=array("id_product"=>"название 1",
                          "text"=>"название 2",
                          "description"=>"Рецензия",
                          "score"=>"Оценка",
                          "author"=>"Aвтор"
                          );

$lang->reviews_menu=array("add"=>"Добавь",
                          "list"=>"сторона");
$lang->reviews_list_bar="Листа рекордов";

$lang->reviews_info="Рецензия продукта: ";

$lang->reviews_no_product="К сожалению твоя рецензия не выслана. Приносим извенения.";

$lang->reviews_send_ok="Tвоя рецензия выслана. Благодарим.";

$lang->reviews_send_ok_again="Tвоя рецензия уже отправлена. Можешь оценить инный продукт :-)";

$lang->reviews_close="Закрой";

$lang->reviews_send="Отправь";

$lang->edit_submit="Отправь";

$lang->reviews_anonymous="Aнонимный";

?>