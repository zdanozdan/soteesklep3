<?php
/**
*
* Plik konfiguracyjny systemu offline
*
* @author  rdiak@sote.pl
* @version $Id: config.inc.php,v 1.38 2005/04/18 07:18:46 scalak Exp $
* @package    offline
* @subpackage main
*/

//typ danych ktore ladujemy ( csv, dbf, xml)
$config->offline_data_type="csv";
//$config->offline_data_type="csv";

//wersja sklepu ( ilosc produktow )
$config->offline_nccp='1388';

//tryb pracy systemu offline
// new - ladujemy caly cennik, update - aktualizujemy cennik, continue - dokanczamy instalacje
$config->offline_mode="new";

//  nazwa pliku z cennikiem ladowanygo na serwer
$config->offline_filename="data_exel.txt";
//$config->offline_filename="data_excel.txt";

//plik logow gdzie bêd± zapisywane informacje o b³êdach
$config->offline_file_error="error.log";

// separator pliku z danymi wejsciowymi
$config->offline_separator="\t";

// sciezka do pliku z danymi do aktualizacji
$config->offline_path_file="tmp";

// kodowanie danych w pliku ¼r-Aód-B³owym
$config->offline_source_encoding="win-1250";

// docelowe kodowanie danych 
$config->offline_target_encoding="iso8859-2";

// nazwa tabeli do ktorej ladujemy dane
$config->offline_table="main";

// nazwa pola ktore w zapytaniach warunkowych sql bedzie kluczem
$config->offline_field_sql="user_id";

// czy pierwsza linia w pliku zawiera opis kolumn
// true - pierwsza linia zawiera opis false - piersza linia to dane
$config->offline_first_line='true';

// czy istnieje pole statusu w rekordzie czuli A U D S ( co robimy z rekodrem )
// jesli nie false pole to nie istnieje i po prostu insertujemy wszystkie rekody do bazy
$config->offline_status_field="true";

//zmienna ktora definuje czy ladowany plik ma strukture taka jak w tablicy
// true - $config->offline_file_struct, false - $config->offline_current_columns  
$config->offline_load_mode='true';

// definicja struktury pliku 
$config->offline_file_struct=array(
                                   "command"=>"command",
                                   "user_id"=>"string",
                                   "price_brutto"=>"null",
                                   "xml_description_L0"=>"null",
                                   "xml_short_description_L0"=>"null",
                                   "photo"=>"null",
                                   "flash"=>"null",
                                   "flash_html"=>"null",
                                   "pdf"=>"null",
                                   "xml_options"=>"null",
                                   "promotion"=>"null",
                                   "newcol"=>"null",
                                   "bestseller"=>"null",
                                   "main_page"=>"null",
                                   "active"=>"null",
                                   "name_L0"=>"null",
                                   "producer"=>"null",
                                   "category1"=>"null",
                                   "category2"=>"null",
                                   "category3"=>"null",
                                   "category4"=>"null",
                                   "category5"=>"null",
                                   "id_currency"=>"null",
                                   "vat"=>"null",
                                   "price_brutto_detal"=>"null",
                                   "id_available"=>"null",
		                           "price_brutto_2"=>"null",
								   "hidden_price"=>"null",
								   "discount"=>"null",
								   "accessories"=>"null",
								   "price_currency"=>"null",
								   "max_discount"=>"null",
								   "onet_category"=>"null",
								   "onet_export" =>"null",
								   "onet_status"=>"null",
								   "onet_image_export"=>"null",
								   "onet_image_desc"=>"null",
								   "onet_image_title"=>"null",
								   "onet_attrib"=>"null",
								   "google_title"=>"null",
								   "google_keywords"=>"null",
								   "google_description"=>"null",
		                           "category_multi_1"=>"null",
		                           "category_multi_2"=>"null",
                                   "ask4price"=>"null",
                                   "weight"=>"null",
                                   "status_vat"=>"null",
                                   );

// tablica asocjacyjna wiazaca dane z pliku z polami bazy danych
$config->offline_relation=array(
                                   "user_id"=>"user_id",
                                   "price_brutto"=>"price_brutto",
                                   "xml_description_L0"=>"xml_description",
                                   "xml_short_description_L0"=>"xml_short_description",
                                   "photo"=>"photo",
                                   "flash"=>"flash",
                                   "flash_html"=>"flash_html",
                                   "pdf"=>"pdf",
                                   "xml_options"=>"xml_options",
                                   "promotion"=>"promotion",
                                   "newcol"=>"newcol",
                                   "bestseller"=>"bestseller",
                                   "main_page"=>"main_page",
                                   "active"=>"active",
                                   "name_L0"=>"name",
                             		"id_producer"=>"compute",
                             		"producer"=>"producer",
                             		"id_category1"=>"compute",
                             		"category1"=>"category1",
                             		"id_category2"=>"compute",
                             		"category2"=>"category2",
                             		"id_category3"=>"compute",
                             		"category3"=>"category3",
                             		"id_category4"=>"compute",
                             		"category4"=>"category4",
                             		"id_category5"=>"compute",
                             		"category5"=>"category5",
                                   "id_currency"=>"id_currency",
                                   "vat"=>"vat",
                                   "price_brutto_detal"=>"price_brutto_detal",
                                   "id_available"=>"id_available",
		                           "price_brutto_2"=>"price_brutto_2",
								   "hidden_price"=>"hidden_price",
								   "discount"=>"discount",
								   "accessories"=>"accessories",
								   "price_currency"=>"price_currency",
								   "max_discount"=>"max_discount",
								   "onet_category"=>"onet_category",
								   "onet_export" =>"onet_export",
								   "onet_status"=>"onet_status",
								   "onet_image_export"=>"onet_image_export",
								   "onet_image_desc"=>"onet_image_desc",
								   "onet_image_title"=>"onet_image_title",
								   "onet_attrib"=>"onet_attrib",
								   "google_title"=>"google_title",
								   "google_keywords"=>"google_keywords",
								   "google_description"=>"google_description",
		                           "category_multi_1"=>"category_multi_1",
		                           "category_multi_2"=>"category_multi_2",
                                    "ask4price"=>"ask4price",
                                   "weight"=>"weight",
                                   "status_vat"=>"status_vat",
                              );

// nazwy kolumn dla u¿ytkownika 
$config->offline_names_column=array(
                                   "user_id"=>"ID produktu",
                                   "price_brutto"=>"Cena brutto",
                                   "xml_description_L0"=>"Pe³ny opis produktu",
                                   "xml_short_description_L0"=>"Krótki opis produktu",
                                   "photo"=>"Fotografia produktu",
                                   "flash"=>"Fotografia Flash",
                                   "flash_html"=>"Kod fotografi flash",
                                   "pdf"=>"Fotografia PDF",
                                   "xml_options"=>"Opcje do produktu",
                                   "promotion"=>"Produkty promocyjne",
                                   "newcol"=>"Nowo¶æ",
                                   "bestseller"=>"Bestseller",
                                   "main_page"=>"Strona g³ówna",
                                   "active"=>"Aktywny",
                                   "name_L0"=>"Nazwa produktu",
                                   "producer"=>"Producent",
                                   "category1"=>"Kategoria 1",
                                   "category2"=>"Kategoria 2",
                                   "category3"=>"Kategoria 3",
                                   "category4"=>"Kategoria 4",
                                   "category5"=>"Kategoria 5",
                                   "id_currency"=>"Waluta",
                                   "vat"=>"Stawka VAT",
                                   "price_brutto_detal"=>"Stara Cena",
    			                   "id_available"=>"Dostêpno¶æ",
	                               "price_brutto_2"=>"Cena hurtowa",
	                               "hidden_price"=>"Nie pokazuj ceny",
								   "discount"=>"Rabat",
								   "accessories"=>"Akcesoria",
								   "price_currency"=>"Cena w walucie",
								   "max_discount"=>"Max Rabat",
								   "onet_category"=>"Kategoria OnetPasa¿",
								   "onet_export" =>"Export OnetPasa¿",
								   "onet_status"=>"Status OnetPasa¿",
								   "onet_image_export"=>"Obrazek Export OnetPasa¿",
								   "onet_image_desc"=>"Obrazek opis OnetPasa¿",
								   "onet_image_title"=>"Obrazek tytu³ OnetPasa¿",
								   "onet_attrib"=>"Atrybuty OnetPasa¿",
								   "google_title"=>"Google tytu³",
								   "google_keywords"=>"Google s³owa",
								   "google_description"=>"Google opis",
		                           "category_multi_1"=>"Produkt w kategorii 2",
		                           "category_multi_2"=>"Produkt w kategorii 3",
                                   "ask4price"=>"Zapytaj o cenê",
                                   "weight"=>"Objêto¶æ produktu",
                                   "status_vat"=>"Sprzeda¿ bez Vat",
                                   );

// jakie pola uzytkownika chce zaladowac w aktualnej sesji aktualizacji 		    
$config->offline_current_columns=array(
                                       	"name"=>"null",
									   	"user_id"=>"null",
 									   	"price_brutto"=>"null",
                                   		"vat"=>"null",
                                        "category1"=>"null",
                                       );
?>
