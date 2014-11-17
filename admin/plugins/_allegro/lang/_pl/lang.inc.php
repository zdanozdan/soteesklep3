<?php
$lang->close="Zamknij okno";
$lang->allegro_bar=array(
                      "index"=>"Allegro",
                      "config"=>"Allegro - konfiguracja",
                      "export"=>"Aukcje do wystawienia na Allegro",
                      "cat"=>"Import kategorii z Allegro",   
                      "list"=>"Aukcje wystawione na Allegro",
                      "delete"=>"Kasowanie aukcji",	
                      );
$lang->allegro_options=array(
                'config'=>"Konfiguracja",
                'export'=>"Aukcje do wystawienia",
                'send'=>"Aukcje wystawione",
                'category'=>"Import Danych",
                'trans'=>"Export Transakcji",
                'data'=>"Typ danych do pobrania",
                'cat'=>"Pobierz drzewo kategorii",
                'adv'=>"Pobierz korzy¶ci",
                'prod'=>"Pobierz producentów",
                'field'=>"Pobierz dodatkowe kategorie",
                'filter'=>"Pobierz filtry",
                'all_prod'=>"Pobierz wszystkie produkty",
                'one_prod'=>"Pobierz jeden produkt",
                'id_one_prod'=>"Id produktu",
                'vtree'=>"Sprawd¼ wa¿no¶æ drzewa kategorii",
                'help'=>"Pomoc",
                'other'=>"Pobierz inne parametry",
                'test'=>"Test"
                );
$lang->allegro_config=array(
						"options"=>"Opcje allegro",
						"login"=>"Login",
						"login_test"=>"Login Test",
						"password"=>"Has³o",
						"password_test"=>"Has³o Test",
						"web_api_key"=>"Klucz Web-API",
						"country_code"=>"Country Code",
						"country_code_test"=>"Country Code Test",
                        "save"=>"Zapisz",
                        "category"=>"Wybierz kategorie Allegro",
                        "category_test"=>"Wybierz kategorie testowe Allegro",
                        "version"=>"Wersja WEBAPI",
                        "version_test"=>"Wersja WEBAPI Test",
                        "server"=>"Adres serwera SOAP Allegro",
                        "country"=>"Kraj",
                        "state"=>"Województwo",
                        "city"=>"Miejscowo¶æ",
                        "state_select"=>"Wybierz województwo",
                        "mode"=>"Tryb pracy modu³u",
                        "product"=>"Tryb produkcjny",
                        "test"=>"Tryb testowy",
                         );


$lang->allegro=array(
                        "title"=>"System <b>Allegro</b>, jest przeznaczony do zarz±dzania produktami ze sklepu do Allegro.",
                        "config"=>"Je¶li chcesz przeprowadziæ konfiguracje parametrów Alelgro wybierz zak³adkê",
                        "export"=>"Je¶li chcesz wyeksportowaæ produkty ze sklepu do Allegro wybierz zak³adkê",

                        );
    
$lang->allegro_get_cat=array(
                'parse'=>"Pobranie i parasowanie kategorii - OK",
                'loaddb'=>"£adowanie do bazy danych - OK",
                'file'=>"Tworzenie pliku z kategoriami - OK",
                'error_file'=>"Tworzenie pliku z kategoriami - Error",
                'error_loaddb'=>"£adowanie do bazy danych - Error",
                'error_parse'=>"Problem z komnikacj± - spróbuj pó¼niej  - Error",
                'timeout'=>"Trwa pobieranie danych z Allegro. Mo¿e to potrwaæ kilka minut.",
                'validtree_ok'=>"<br>Drzewo kategorii znajduj±ce siê aktualnie w sklepie jest <b>aktualne</b>.<br>Nie ma potrzeby sci±gania nowego drzewa kategorii.",
                'validtree_error'=>"<br>Drzewo kategorii znajduj±ce siê aktualnie w skepie jest <font color=red><b>nieaktualne</b>. Nale¿y zaktualizwoaæ drzewo kategorii",
                'validtree_save_ok'=>"<br>Identyfikator drzewa kategorii zosta³ zapisany",
                'validtree_save_error'=>"<br>Identyfikator drzewa kategorii<font color=red><b>nie zosta³ zapisany. B³±d</b>",
                'tree_load_ok'=>"Kategorie zosta³y proprawnie za³adowane do sklepu",
                'tree_load_error'=>"B³±d podczas ³adowania kategorii.Spróbuj jeszcze raz",
                'producer_load_ok'=>"Producenci zostali proprawnie za³adowani do sklepu",
                'producer_load_error'=>"B³±d podczas ³adowania producentów.Spróbuj jeszcze raz",
                'advant_load_ok'=>"Korzy¶ci zosta³y proprawnie za³adowane do sklepu",
                'advant_load_error'=>"B³±d podczas ³adowania Korzy¶ci.Spróbuj jeszcze raz",
                'fields_load_ok'=>"Korzy¶ci zosta³y proprawnie za³adowane do sklepu",
                'fields_load_error'=>"B³±d podczas ³adowania Korzy¶ci.Spróbuj jeszcze raz",
                'filters_load_ok'=>"Filtry zosta³y proprawnie za³adowane do sklepu",
                'filters_load_error'=>"B³±d podczas ³adowania Filtrów.Spróbuj jeszcze raz",
                'check_config'=>"Sprawdz konfiguracjê modu³u WP i wpisz prawid³owe dane dostêpu.",
                );
$lang->allegro_category=array(
                'info'=>"Allegro.pl posiada w³asne drzewo kategorii. ¯eby korzystaæ z kategorii Allegro oraz
				kwalifikowaæ produkty sklepowe do kategorii Allegro, nale¿y do³±czyæ te kategorie do sklepu.", 
                'category'=>"Pobra¿ kategorie <b>wp Pasa¿</b> do sklepu.",
                'submit'=>"Pobierz dane",
                );
$lang->get_category_ok="Pobieranie kategorii poprawne.";
$lang->get_other_ok="Pobieranie parametrów poprawne.";
$lang->allegro_error_auction=array(
        "problem"=>"<b>Problem z wystawieniem aukcji dla produktu o identyfikatorze:: </b>",
        "type_error"=>"<b>B³±d:: </b>",
        "category"=>"Problem z pobraniem kategorii. Spróbuj jeszcze raz.",
        );

$lang->set_auction=array(
                        "ok"=>"<b>Wystawiono aukcjê z produktem o identyfikatorze:: </b>",
                        "number"=>"<b>Numer wystawionej aukcji:: </b>",
                        "url"=>"<b>Adres URL do aukcji:: </b>",
                        );
$lang->allegro_list=array(
                            "allegro_product_name"=>"Nazwa aukcji",
                            "allegro_price_start"=>"Cena wywo³awcza",
                            "allegro_number"=>"Numer aukcji",
                            "allegro_send"=>"Typ aukcji",
                            );
$lang->allegro_send="Wystaw";
?>
