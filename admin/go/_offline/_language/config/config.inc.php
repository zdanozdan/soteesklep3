<?php
/**
*
* Plik konfiguracyjny systemu offline
*
* @author  rdiak@sote.pl
* @version $Id: config.inc.php,v 1.1 2005/04/21 07:32:25 scalak Exp $
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
$config->offline_filename="lang_exel.txt";
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
                                   "xml_description_L1"=>"null",
                                   "xml_short_description_L1"=>"null",
                                   "name_L1"=>"null",
                                   "xml_description_L2"=>"null",
                                   "xml_short_description_L2"=>"null",
                                   "name_L2"=>"null",
                                   "xml_description_L3"=>"null",
                                   "xml_short_description_L3"=>"null",
                                   "name_L3"=>"null",
                                   "xml_description_L4"=>"null",
                                   "xml_short_description_L4"=>"null",
                                   "name_L4"=>"null",
                                   );

// tablica asocjacyjna wiazaca dane z pliku z polami bazy danych
$config->offline_relation=array(
                                   "user_id"=>"user_id",
                                   "xml_description_L1"=>"xml_description",
                                   "xml_short_description_L1"=>"xml_short_description",
                                   "name_L1"=>"name",
                                   "xml_description_L2"=>"xml_description",
                                   "xml_short_description_L2"=>"xml_short_description",
                                   "name_L2"=>"name",
                                   "xml_description_L3"=>"xml_description",
                                   "xml_short_description_L3"=>"xml_short_description",
                                   "name_L3"=>"name",
                                   "xml_description_L4"=>"xml_description",
                                   "xml_short_description_L4"=>"xml_short_description",
                                   "name_L4"=>"name",
                                   );

// nazwy kolumn dla u¿ytkownika 
$config->offline_names_column=array(
                                   "user_id"=>"ID produktu",
                                   "xml_description_L1"=>"Pe³ny opis produktu w pierwszym jêzyku",
                                   "xml_short_description_L1"=>"Krótki opis produktu w pierwszym jêzyku",
                                   "name_L1"=>"Nazwa produktu w pierwszym jêzyku",
                                   "xml_description_L2"=>"Pe³ny opis produktu w drugim jêzyku",
                                   "xml_short_description_L2"=>"Krótki opis produktu w drugim jêzyku",
                                   "name_L2"=>"Nazwa produktu w drugim jêzyku",
                                   "xml_description_L3"=>"Pe³ny opis produktu w trzecim jêzyku",
                                   "xml_short_description_L3"=>"Krótki opis produktu w trzecim jêzyku",
                                   "name_L3"=>"Nazwa produktu w trzecim jêzyku",
                                   "xml_description_L4"=>"Pe³ny opis produktu w czwartym jêzyku",
                                   "xml_short_description_L4"=>"Krótki opis produktu w czwartym jêzyku",
                                   "name_L4"=>"Nazwa produktu w czwartym jêzyku",
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
