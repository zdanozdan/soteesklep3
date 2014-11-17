<?php
/**
* @version    $Id: config.inc.php,v 1.2 2004/12/20 17:58:32 maroslaw Exp $
* @package    offline
* @subpackage main_keys
*/

//typ danych ktore ladujemy ( csv, dbf, xml)
$config->offline_data_type="csv";

//wersja sklepu ( ilosc produktow )
$config->offline_nccp='1388';

//tryb pracy systemu offline
// new - ladujemy caly cennik, update - aktualizujemy cennik, continue - dokanczamy instalacje
$config->offline_mode="new";

//  nazwa pliku z cennikiem ladowanygo na serwer
$config->offline_filename="data_excel.txt";

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
$config->offline_table="main_keys";

// nazwa pola ktore w zapytaniach warunkowych sql bedzie kluczem
$config->offline_field_sql="main_key";

// czy pierwsza linia w pliku zawiera opis kolumn
// true - pierwsza linia zawiera opis false - piersza linia to dane
$config->offline_first_line='false';


// czy istnieje pole statusu w rekordzie czuli A U D S ( co robimy z rekodrem )
// jesli nie false pole to nie istnieje i po prostu insertujemy wszystkie rekody do bazy
$config->offline_status_field="false";


//zmienna ktora definuje czy ladowany plik ma strukture taka jak w tablicy
// true - $config->offline_file_struct, false - $config->offline_current_columns  
$config->offline_load_mode='true';

// definicja struktury pliku 
$config->offline_file_struct=array(
                                   	"user_id_main"=>"nominal",
									"main_key"=>"pin",
								   );

// definicje typow danych dla bazy danych
$config->offline_types=array(
                             "id"=>"int",
							 "user_id_main"=>"string",
							 "main_key"=>"string",
							 );

// tablica asocjacyjna wiazaca dane z pliku z polami bazy danych
$config->offline_relation=array(
                             "user_id_main"=>"user_id_main",
							 "main_key"=>"main_key",
							 );

// nazwy kolumn dla u¿ytkownika
$config->offline_names_colum=array(
                                   	"user_id_main"=>"ID - unikalny idetyfikator produktu",
									"main_key"=>"PIN",
								   );

// jakie pola uzytkownika chce zaladowac w aktualnej sesji aktualizacji
$config->offline_current_columns=array(
                                  	"user_id_main"=>"string",
									"main_key"=>"string",
									   );
// tablica zawiera pola które maj± zostaæ zaszyfrowane podczas wkladania do bazy danych
$config->offline_code=array("main_key");

?>
