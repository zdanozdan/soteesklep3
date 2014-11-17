<?php
$lang->close="Zamknij okno";
$lang->onet_bar=array(
                      "index"=>"Onet Pasa�",
                      "config"=>"Onet Pasa� - Konfiguracja",
                      "export"=>"Export oferty do Onet Pasa�",
                      "cat"=>"Import kategorii z Onet Pasa�",
                      "trans"=>"Export transakcji do Onet Pasa�"    	
                      );
$lang->onet_options=array(
                          "config"=>"Konfiguracja",
                          "export"=>"Export produkt�w",
                          "category"=>"Import Kategorii",
                          "trans"=>"Export Transakcji",
                          "help"=>"Pomoc",
                          );
$lang->onet_config=array(
                         "options"=>"Opcje Onet Pasa�",
                         "network"=>"Opcje sieciowe Onet Pasa�",
                         "id"=>"ID sklepu",
                         "mode"=>"Tryb �adowania danych", 
                         "full"=>"Pe�ny eksport",
                         "update"=>"Przyrostowy eksport",
                         "login"=>"Login",
                         "pass"=>"Has�o",
                         "server"=>"Adres serwera SOAP",
                         "test_server"=>"Adres testowego serwera SOAP",
                         "get_category"=>"Pobieranie kategorii",
                         "category"=>"Pobieranie kategorii",
                         "biling"=>"Wysy�anie produkt�w",
                         "transaction"=>"Potwierdzanie transakcji",
                         "port"=>"Port Server SOAP",
                         "save"=>"Zapisz",
                         "category"=>"Wybierz kategorie Onetowe",
                         "confirm"=>"Adres potwierdzania transakcji",
                         "load"=>"Tryb pracy modu�u",
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
                          "loaddb"=>"�adowanie do bazy danych - OK",
                          "file"=>"Tworzenie pliku z kategoriami - OK",    
                          "error_file"=>"Tworzenie pliku z kategoriami - Error",    
                          "error_loaddb"=>"�adowanie do bazy danych - Error",
                          "error_parse"=>"Problem z komnikacj� - spr�buj p�niej  - Error",
                          "timeout"=>"Trwa pobieranie kategorii. Mo�e to potrwa� kilka minut.",
                          );

$lang->onet_load_offer=array(
                             "badxml"=>"Nieprawid�owu plik xml z oferta",
                             "noprod"=>"Brak produkt�w do wyeksportwania",    
                             "timeout"=>"Trwa wysy�anie produkt�w do Onet Pasa�. Mo�e to potrwa� kilka minut.",
                             "count"=>"Ilo�� produkt�w przes�anych do Onet Pasa�",    
                             );

$lang->onet_trans=array(
                        "info"=>"Z tego miejsca mo�na przes�a� sfinalizowane transakcje ze sklepu do Onet Pasa�. 
			Przy transakcjach rozpocz�tych w Onet Pasa� znajduje si� specjalne pole do potwierdzania tych transakcji.
			Lista transakcji kt�re mo�na wys�a� do Onet Pasa� znajduje si� w tym <b><u><a href=/go/_order/onet_trans.php>miejscu</a></u></b>",
                        "notrans"=>"<font color=red>Nie ma �adnej transakcji do wys�ania.</font>",
                        "export"=>"Eksportuj transakcje do <b>Onet Pasa�</b>.",
                        "submit"=>"Eksport Transakcji",
                        "timeout"=>"Trwa wysy�anie transakcji do Onet Pasa�. Mo�e to potrwa� kilka minut.",
                        "trans_log_ok"=>"Transakcja zalogowana poprawnie",
                        "trans_log_error"=>"Transakcja zalogowana niepoprawnie",
                        "show_trans"=>"Poka� transakcje", 
                        );

$lang->onet_pasaz=array(
                        "title"=>"System <b>Onet Pasa�</b>, jest przeznaczony do zarz�dzania produktami ze sklepu z Onet Pasa�.",
                        "config"=>"Je�li chcesz przeprowadzi� konfiguracje parametr�w Onet Pasa� wybierz zak�adk�",
                        "export"=>"Je�li chcesz wyeksportowa� produkty ze sklepu do Onet Pasa� wybierz zak�adk�",
                        "category"=>"Je�li chcesz pobra� drzewo kategorii z Onet Pasa� wybierz  zak�adk�",
                        "transaction"=>"Je�li chcesz wykon� eksport transakcji do Onet Pasa� wybierz zak�adke",  
                        );
$lang->onet_export=array(
                         "info"=>"Z tego miejsca mo�na wyeksportowa� produkty ze sklepu do Onet Pasa�. 
			Napierw jednak nale�y ka�demu produktowi nada� odpowiedni� kategori� oraz ustawi� inne parametry exportu.
			Mo�esz to zrobic w tym <b><u><a href=/go/_category/all.php>miejscu</a></u></b>",
                         "export"=>"Eksportuj  produkty ze sklepu do <b>Onet Pasa�</b>.",
                         "submit"=>"Eksport produkt�w",
                         "noproduct"=>"<font color=red>Brak produkt�w do eksportu.</font>",
                         );
$lang->onet_category=array(
                           "info"=>"Onet Pasa� posiada w�asne drzewo kategorii. �eby korzysta� z kategorii Onet Pasa� oraz
				kwalifikowa� produkty sklepowe do kategorii Onet Pasa�, nale�y do��czy� te kategorie do sklepu 
				Przyporz�dkowa� produkt ze skelpu do kategorii z Onet Pasa� mo�esz zrobic w tym <b><u><a href=/go/_category/all.php>miejscu</a></u></b>",
                           "category"=>"Pobra� kategorie <b>Onet Pasa�</b> do sklepu.",
                           "submit"=>"Pobierz kategorie",
                           );

?>
