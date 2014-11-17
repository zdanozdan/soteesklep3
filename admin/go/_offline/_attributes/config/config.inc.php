<?php
/**
* @version    $Id: config.inc.php,v 1.6 2004/12/20 17:58:21 maroslaw Exp $
* @package    offline
* @subpackage attributes
*/

//typ danych ktore ladujemy ( csv, dbf, xml)
$config->offline_data_type="csv";

//wersja sklepu ( ilosc produktow )
$config->offline_nccp='5000';

//tryb pracy systemu offline
// new - ladujemy caly cennik, update - aktualizujemy cennik, continue - dokanczamy instalacje
$config->offline_mode="new";

//  nazwa pliku z cennikiem ladowanygo na serwer
$config->offline_filename="attributes_excel.txt";

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
$config->offline_table="attributes";

// nazwa pola ktore w zapytaniach warunkowych sql bedzie kluczem
$config->offline_field_sql="main_key";

// informacja o tym czy bedziemy sprawdzac unikalnosc rekordow
$config->offline_check_record='false';

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
                                   "id_main"=>"string",
//                                   "price"=>"price",
                                   "attribute1"=>"null",
                                   "attribute2"=>"null",
                                   "attribute3"=>"null",
                                   "attribute4"=>"null",
                                   "attribute5"=>"null",
                                   "attribute6"=>"null",
                                   "attribute7"=>"null",
                                   "attribute8"=>"null",
                                   "attribute9"=>"null",
                                   "attribute10"=>"null"
                                   );

// definicje typow danych dla bazy danych 
$config->offline_types=array(
                             "id_main"=>"string",
//                             "price"=>"price",
                             "attribute1"=>"null",
                             "attribute2"=>"null",
                             "attribute3"=>"null",
                             "attribute4"=>"null",
                             "attribute5"=>"null",
                             "attribute6"=>"null",
                             "attribute7"=>"null",
                             "attribute8"=>"null",
                             "attribute9"=>"null",
                             "attribute10"=>"null"
                             );

// tablica asocjacyjna wiazaca dane z pliku z polami bazy danych
$config->offline_relation=array(
                             "id_main"=>"id_main",
//                             "price"=>"price",
                             "attribute1"=>"attribute1",
                             "attribute2"=>"attribute2",
                             "attribute3"=>"attribute3",
                             "attribute4"=>"attribute4",
                             "attribute5"=>"attribute5",
                             "attribute6"=>"attribute6",
                             "attribute7"=>"attribute7",
                             "attribute8"=>"attribute8",
                             "attribute9"=>"attribute9",
                             "attribute10"=>"attribute10"
                             );

// nazwy kolumn dla u~ytkownika 
$config->offline_names_colum=array("id_main"=>"Identyfikator produktu",
//                                   "price"=>"Cena produktu dla wybranych atrybutow",
                                   "attribute1"=>"Atrybut 1",
                                   "attribute2"=>"Atrybut 2",
                                   "attribute3"=>"Atrybut 3",
                                   "attribute4"=>"Atrybut 4",
                                   "attribute5"=>"Atrybut 5",
                                   "attribute6"=>"Atrybut 6",
                                   "attribute7"=>"Atrybut 7",
                                   "attribute8"=>"Atrybut 8",
                                   "attribute9"=>"Atrybut 9",
                                   "attribute10"=>"Atrybut 10",
                                   );

// tablica zawiera pola które maj± zostaæ zaszyfrowane podczas wkladania do bazy danych
$config->offline_code=array("main_key");

?>
