<?php
/**
 * Lokalna definicja lang
 * 
 * @author  lech@sote.pl
 * @template_version Id: lang.inc.php,v 2.6 2004/02/12 11:02:07 maroslaw Exp
 * @version $Id: lang.inc.php,v 1.4 2005/11/29 08:53:48 lechu Exp $
 * @package soteesklep
 */

$lang->deliverers_bar="deliverers";

// dodanie rekordu
$lang->deliverers_add_bar="Dodaj nowego dostawcê magazynowego";
$lang->deliverers_record_add="Dostawca magazynowy dodany";

// aktualizacja rekordu
$lang->deliverers_update_bar="Aktualizacja dostawcy magazynowego";
$lang->deliverers_edit_update_ok="Dostawca magazynowy zaktualizowany";

// komunikaty o bledach, pojawia sie jesli dane pole jest wymagane i nie jest wprowadzone
// jesli jakies pole jest wymagane, to odpowiedni wpis dla tego pola musi sie znalezc w ponizszej tablicy !
$lang->deliverers_form_errors=array("name"=>"Brak nazwy dostawcy",
                                 "email"=>"Brak e-maila dostawcy"
				);

// nazwy kolumn do formularza, nazwy pojawia sie przy wyswietleniu pol formularza - w edycji
$lang->deliverers_cols=array("ID"    =>"ID",                          
                          "name"=>"Nazwa dostawcy magazynowego",
                          "email"=>"adres email"
                          );

// pola, ktore poajwia sie na liscie rekordow + nazwy (na podstawie tych danych sa generowane opisy do <th>)
$lang->deliverers_cols_list=array("ID"    =>"ID",
                               "change"=>"",
                               "name"=>"Nazwa dostawcy magazynowego",
                               "email"=>"adres email"
                               );

$lang->deliverers_menu=array("add"=>"Dodaj dostawcê magazynowego",
                            "list"=>"Lista dostawców magazynowych",
                            "deliverers"=>"Dostawcy magazynowi",
                            "availability"=>"Dostêpno¶æ",
                            "depository"=>"Magazyn",
                          );

$lang->deliverers_list_bar="Lista dostawców magazynowych";
?>