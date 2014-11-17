<?php
/**
*
* Plik konfiguracyjny systemu offline
*
* @author  rdiak@sote.pl
* @version $Id: config.inc.php,v 1.1 2005/12/22 11:40:50 scalak Exp $
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
$config->offline_filename="dep_exel.txt";
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
$config->offline_table="depository";

// nazwa pola ktore w zapytaniach warunkowych sql bedzie kluczem
$config->offline_field_sql="user_id_main";

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
                                   "user_id_main"=>"string",
                                   "num"=>"null",
                                   "id_deliverer"=>"id_deliverer",
                                   "min_num"=>"null",
                                   );

// tablica asocjacyjna wiazaca dane z pliku z polami bazy danych
$config->offline_relation=array(
                                   "user_id_main"=>"user_id",
                                   "num"=>"num",
                                   "id_deliverer"=>"id_deliverer",
                                   "min_num"=>"min_num",
                                   );

// nazwy kolumn dla u¿ytkownika 
$config->offline_names_column=array(
                                   "user_id_main"=>"ID produktu",
                                   "num"=>"Liczba produktów",
                                   "id_deliverer"=>"Identyfikator dostawcy",
                                   "min_num"=>"Minimalna ilo¶æ w magazynie",
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
