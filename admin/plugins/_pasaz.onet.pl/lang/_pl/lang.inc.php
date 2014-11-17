<?php
$lang->close="Zamknij okno";
$lang->onet_bar=array(
                      "index"=>"Onet Pasa¿",
                      "config"=>"Onet Pasa¿ - Konfiguracja",
                      "export"=>"Export oferty do Onet Pasa¿",
                      "cat"=>"Import kategorii z Onet Pasa¿",
                      "trans"=>"Export transakcji do Onet Pasa¿"    	
                      );
$lang->onet_options=array(
                          "config"=>"Konfiguracja",
                          "export"=>"Export produktów",
                          "category"=>"Import Kategorii",
                          "trans"=>"Export Transakcji",
                          "help"=>"Pomoc",
                          );
$lang->onet_config=array(
                         "options"=>"Opcje Onet Pasa¿",
                         "network"=>"Opcje sieciowe Onet Pasa¿",
                         "id"=>"ID sklepu",
                         "mode"=>"Tryb ³adowania danych", 
                         "full"=>"Pe³ny eksport",
                         "update"=>"Przyrostowy eksport",
                         "login"=>"Login",
                         "pass"=>"Has³o",
                         "server"=>"Adres serwera SOAP",
                         "test_server"=>"Adres testowego serwera SOAP",
                         "get_category"=>"Pobieranie kategorii",
                         "category"=>"Pobieranie kategorii",
                         "biling"=>"Wysy³anie produktów",
                         "transaction"=>"Potwierdzanie transakcji",
                         "port"=>"Port Server SOAP",
                         "save"=>"Zapisz",
                         "category"=>"Wybierz kategorie Onetowe",
                         "confirm"=>"Adres potwierdzania transakcji",
                         "load"=>"Tryb pracy modu³u",
                         "test"=>"Tryb testowy",
                         "product"=>"Tryb produkcyjny",
                         "back"=>"Ostatnie ustawienia",
                         "partner_name"=>"Nazwa partnera",

                         );
$lang->onet_soap=array(
                       "no_header"=>"Brak naglowka odpowiedzi z Onet Pasaz",
                       "bad_reply"=>"Brak odpowiedzi z serwera SOAP",
                       "not_connect"=>"Nie mozna polaczyc sie z serwerem",
                       );
$lang->onet_get_cat=array(
                          "parse"=>"Pobranie i parasowanie kategorii - OK",
                          "loaddb"=>"£adowanie do bazy danych - OK",
                          "file"=>"Tworzenie pliku z kategoriami - OK",    
                          "error_file"=>"Tworzenie pliku z kategoriami - Error",    
                          "error_loaddb"=>"£adowanie do bazy danych - Error",
                          "error_parse"=>"Problem z komnikacj± - spróbuj pó¼niej  - Error",
                          "timeout"=>"Trwa pobieranie kategorii. Mo¿e to potrwaæ kilka minut.",
                          );

$lang->onet_load_offer=array(
                             "badxml"=>"Nieprawid³owu plik xml z oferta",
                             "noprod"=>"Brak produktów do wyeksportwania",    
                             "timeout"=>"Trwa wysy³anie produktów do Onet Pasa¿. Mo¿e to potrwaæ kilka minut.",
                             "count"=>"Ilo¶æ produktów przes³anych do Onet Pasa¿",    
                             );

$lang->onet_trans=array(
                        "info"=>"Z tego miejsca mo¿na przes³aæ sfinalizowane transakcje ze sklepu do Onet Pasa¿. 
			Przy transakcjach rozpoczêtych w Onet Pasa¿ znajduje siê specjalne pole do potwierdzania tych transakcji.
			Lista transakcji które mo¿na wys³aæ do Onet Pasa¿ znajduje siê w tym <b><u><a href=/go/_order/onet_trans.php>miejscu</a></u></b>",
                        "notrans"=>"<font color=red>Nie ma ¿adnej transakcji do wys³ania.</font>",
                        "export"=>"Eksportuj transakcje do <b>Onet Pasa¿</b>.",
                        "submit"=>"Eksport Transakcji",
                        "timeout"=>"Trwa wysy³anie transakcji do Onet Pasa¿. Mo¿e to potrwaæ kilka minut.",
                        "trans_log_ok"=>"Transakcja zalogowana poprawnie",
                        "trans_log_error"=>"Transakcja zalogowana niepoprawnie",
                        "show_trans"=>"Poka¿ transakcje", 
                        );

$lang->onet_pasaz=array(
                        "title"=>"System <b>Onet Pasa¿</b>, jest przeznaczony do zarz±dzania produktami ze sklepu z Onet Pasa¿.",
                        "config"=>"Je¶li chcesz przeprowadziæ konfiguracje parametrów Onet Pasa¿ wybierz zak³adkê",
                        "export"=>"Je¶li chcesz wyeksportowaæ produkty ze sklepu do Onet Pasa¿ wybierz zak³adkê",
                        "category"=>"Je¶li chcesz pobraæ drzewo kategorii z Onet Pasa¿ wybierz  zak³adkê",
                        "transaction"=>"Je¶li chcesz wykonæ eksport transakcji do Onet Pasa¿ wybierz zak³adke",  
                        );
$lang->onet_export=array(
                         "info"=>"Z tego miejsca mo¿na wyeksportowaæ produkty ze sklepu do Onet Pasa¿. 
			Napierw jednak nale¿y ka¿demu produktowi nadaæ odpowiedni± kategoriê oraz ustawiæ inne parametry exportu.
			Mo¿esz to zrobic w tym <b><u><a href=/go/_category/all.php>miejscu</a></u></b>",
                         "export"=>"Eksportuj  produkty ze sklepu do <b>Onet Pasa¿</b>.",
                         "submit"=>"Eksport produktów",
                         "noproduct"=>"<font color=red>Brak produktów do eksportu.</font>",
                         );
$lang->onet_category=array(
                           "info"=>"Onet Pasa¿ posiada w³asne drzewo kategorii. ¯eby korzystaæ z kategorii Onet Pasa¿ oraz
				kwalifikowaæ produkty sklepowe do kategorii Onet Pasa¿, nale¿y do³±czyæ te kategorie do sklepu 
				Przyporz±dkowaæ produkt ze skelpu do kategorii z Onet Pasa¿ mo¿esz zrobic w tym <b><u><a href=/go/_category/all.php>miejscu</a></u></b>",
                           "category"=>"Pobra¿ kategorie <b>Onet Pasa¿</b> do sklepu.",
                           "submit"=>"Pobierz kategorie",
                           );

?>
