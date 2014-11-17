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
                'adv'=>"Pobierz korzy�ci",
                'prod'=>"Pobierz producent�w",
                'field'=>"Pobierz dodatkowe kategorie",
                'filter'=>"Pobierz filtry",
                'all_prod'=>"Pobierz wszystkie produkty",
                'one_prod'=>"Pobierz jeden produkt",
                'id_one_prod'=>"Id produktu",
                'vtree'=>"Sprawd� wa�no�� drzewa kategorii",
                'help'=>"Pomoc",
                'other'=>"Pobierz inne parametry",
                'test'=>"Test"
                );
$lang->allegro_config=array(
						"options"=>"Opcje allegro",
						"login"=>"Login",
						"login_test"=>"Login Test",
						"password"=>"Has�o",
						"password_test"=>"Has�o Test",
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
                        "state"=>"Wojew�dztwo",
                        "city"=>"Miejscowo��",
                        "state_select"=>"Wybierz wojew�dztwo",
                        "mode"=>"Tryb pracy modu�u",
                        "product"=>"Tryb produkcjny",
                        "test"=>"Tryb testowy",
                         );


$lang->allegro=array(
                        "title"=>"System <b>Allegro</b>, jest przeznaczony do zarz�dzania produktami ze sklepu do Allegro.",
                        "config"=>"Je�li chcesz przeprowadzi� konfiguracje parametr�w Alelgro wybierz zak�adk�",
                        "export"=>"Je�li chcesz wyeksportowa� produkty ze sklepu do Allegro wybierz zak�adk�",

                        );
    
$lang->allegro_get_cat=array(
                'parse'=>"Pobranie i parasowanie kategorii - OK",
                'loaddb'=>"�adowanie do bazy danych - OK",
                'file'=>"Tworzenie pliku z kategoriami - OK",
                'error_file'=>"Tworzenie pliku z kategoriami - Error",
                'error_loaddb'=>"�adowanie do bazy danych - Error",
                'error_parse'=>"Problem z komnikacj� - spr�buj p�niej  - Error",
                'timeout'=>"Trwa pobieranie danych z Allegro. Mo�e to potrwa� kilka minut.",
                'validtree_ok'=>"<br>Drzewo kategorii znajduj�ce si� aktualnie w sklepie jest <b>aktualne</b>.<br>Nie ma potrzeby sci�gania nowego drzewa kategorii.",
                'validtree_error'=>"<br>Drzewo kategorii znajduj�ce si� aktualnie w skepie jest <font color=red><b>nieaktualne</b>. Nale�y zaktualizwoa� drzewo kategorii",
                'validtree_save_ok'=>"<br>Identyfikator drzewa kategorii zosta� zapisany",
                'validtree_save_error'=>"<br>Identyfikator drzewa kategorii<font color=red><b>nie zosta� zapisany. B��d</b>",
                'tree_load_ok'=>"Kategorie zosta�y proprawnie za�adowane do sklepu",
                'tree_load_error'=>"B��d podczas �adowania kategorii.Spr�buj jeszcze raz",
                'producer_load_ok'=>"Producenci zostali proprawnie za�adowani do sklepu",
                'producer_load_error'=>"B��d podczas �adowania producent�w.Spr�buj jeszcze raz",
                'advant_load_ok'=>"Korzy�ci zosta�y proprawnie za�adowane do sklepu",
                'advant_load_error'=>"B��d podczas �adowania Korzy�ci.Spr�buj jeszcze raz",
                'fields_load_ok'=>"Korzy�ci zosta�y proprawnie za�adowane do sklepu",
                'fields_load_error'=>"B��d podczas �adowania Korzy�ci.Spr�buj jeszcze raz",
                'filters_load_ok'=>"Filtry zosta�y proprawnie za�adowane do sklepu",
                'filters_load_error'=>"B��d podczas �adowania Filtr�w.Spr�buj jeszcze raz",
                'check_config'=>"Sprawdz konfiguracj� modu�u WP i wpisz prawid�owe dane dost�pu.",
                );
$lang->allegro_category=array(
                'info'=>"Allegro.pl posiada w�asne drzewo kategorii. �eby korzysta� z kategorii Allegro oraz
				kwalifikowa� produkty sklepowe do kategorii Allegro, nale�y do��czy� te kategorie do sklepu.", 
                'category'=>"Pobra� kategorie <b>wp Pasa�</b> do sklepu.",
                'submit'=>"Pobierz dane",
                );
$lang->get_category_ok="Pobieranie kategorii poprawne.";
$lang->get_other_ok="Pobieranie parametr�w poprawne.";
$lang->allegro_error_auction=array(
        "problem"=>"<b>Problem z wystawieniem aukcji dla produktu o identyfikatorze:: </b>",
        "type_error"=>"<b>B��d:: </b>",
        "category"=>"Problem z pobraniem kategorii. Spr�buj jeszcze raz.",
        );

$lang->set_auction=array(
                        "ok"=>"<b>Wystawiono aukcj� z produktem o identyfikatorze:: </b>",
                        "number"=>"<b>Numer wystawionej aukcji:: </b>",
                        "url"=>"<b>Adres URL do aukcji:: </b>",
                        );
$lang->allegro_list=array(
                            "allegro_product_name"=>"Nazwa aukcji",
                            "allegro_price_start"=>"Cena wywo�awcza",
                            "allegro_number"=>"Numer aukcji",
                            "allegro_send"=>"Typ aukcji",
                            );
$lang->allegro_send="Wystaw";
?>
