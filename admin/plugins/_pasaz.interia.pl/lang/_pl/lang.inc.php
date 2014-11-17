<?php
$lang->close="Zamknij okno";
$lang->interia_bar=array(
                'index'=>"interia Pasa�",
                'config'=>"interia Pasa� - Konfiguracja",
                'export'=>"Export oferty do interia Pasa�",
                'cat'=>"Import danych z interia Pasa�",
                'trans'=>"Export transakcji do interia Pasa�",
                );
$lang->interia_options=array(
                'config'=>"Konfiguracja",
                'export'=>"Export produkt�w",
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
                );
$lang->interia_config=array(
                'options'=>"Opcje interia Pasa�",
                'network'=>"Opcje sieciowe interia Pasa�",
                'id'=>"ID sklepu nadany przez Administratora interia Pasa�",
                'mode'=>"Tryb �adowania danych do interia Pasa�",
                'full'=>"Pe�ny eksport",
                'update'=>"Przyrostowy eksport",
                'login'=>"Login",
                'pass'=>"Has�o",
                'server'=>"Adres serwera SOAP",
                'test_server'=>"Adres testowego serwera SOAP",
                'get_category'=>"Pobieranie kategorii",
                'category'=>"Wybierz kategorie Interia Pasa�",
                'biling'=>"Wysy�anie produkt�w",
                'transaction'=>"Potwierdzanie transakcji",
                'port'=>"Port Server SOAP",
                'save'=>"Zapisz",
                'confirm'=>"Adres potwierdzania transakcji",
                'load'=>"Tryb pracy modu�u",
                'test'=>"Tryb testowy",
                'product'=>"Tryb produkcyjny",
                'back'=>"Ostatnie ustawienia",
                'partner_name'=>"Nazwa partnera",
                );
$lang->interia_soap=array(
                'no_header'=>"Brak naglowka odpowiedzi z interia Pasaz",
                'bad_reply'=>"Brak odpowiedzi z serwera SOAP",
                'not_connect'=>"Nie mozna polaczyc sie z serwerem",
                );
$lang->interia_get_cat=array(
                'parse'=>"Pobranie i parasowanie kategorii - OK",
                'loaddb'=>"�adowanie do bazy danych - OK",
                'file'=>"Tworzenie pliku z kategoriami - OK",
                'error_file'=>"Tworzenie pliku z kategoriami - Error",
                'error_loaddb'=>"�adowanie do bazy danych - Error",
                'error_parse'=>"Problem z komnikacj� - spr�buj p�niej  - Error",
                'timeout'=>"Trwa pobieranie danych z pasa�u interia. Mo�e to potrwa� kilka minut.",
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
                'check_config'=>"Sprawdz konfiguracj� modu�u interia i interiaisz prawid�owe dane dost�pu.",
                );
$lang->interia_load_offer=array(
                'badxml'=>"Nieprawid�owu plik xml z oferta",
                'noprod'=>"Brak produkt�w do wyeksportwania",
                'timeout'=>"Trwa wysy�anie produkt�w do interia Pasa�. Mo�e to potrwa� kilka minut.",
                'count'=>"Ilo�� produkt�w przes�anych do interia Pasa�",
                );
$lang->interia_trans=array(
                'info'=>"Z tego miejsca mo�na przes�a� sfinalizowane transakcje ze sklepu do interia Pasa�. 
			Przy transakcjach rozpocz�tych w interia Pasa� znajduje si� specjalne pole do potwierdzania tych transakcji.
			Zarz�dza� transakcjami mo�esz z tego <b><u><a href=/go/_order>miejsca</a></u></b>",
                'notrans'=>"Nie ma �adnej transakcji do wys�ania",
                'export'=>"Eksportuj transakcje do <b>interia Pasa�</b>.",
                'submit'=>"Eksport Transakcji",
                'timeout'=>"Trwa wysy�anie transakcji do interia Pasa�. Mo�e to potrwa� kilka minut.",
                'trans_log_ok'=>"Transakcja zalogowana poprawnie",
                'trans_log_error'=>"Transakcja zalogowana niepoprawnie",
                'show_trans'=>"Poka� transakcje",
                );
$lang->interia_pasaz=array(
                'title'=>"System <b>interia Pasa�</b>, jest przeznaczony do zarz�dzania produktami ze sklepu z interia Pasa�.",
                'config'=>"Je�li chcesz przeprowadzi� konfiguracje parametr�w interia Pasa� wybierz zak�adk�",
                'export'=>"Je�li chcesz wyeksportowa� produkty ze sklepu do interia Pasa� wybierz zak�adk�",
                'category'=>"Je�li chcesz pobra� drzewo kategorii z interia Pasa� wybierz  zak�adk�",
                'transaction'=>"Je�li chcesz wykon� eksport transakcji do interia Pasa� wybierz zak�adke",
                );
$lang->interia_export=array(
                'info'=>"Z tego miejsca mo�na wyeksportowa� produkty ze sklepu do interia Pasa�. 
			Napierw jednak nale�y ka�demu produktowi nada� odpowiedni� kategori� oraz ustawi� inne parametry exportu.
			Mo�esz to zrobic w tym <b><u><a href=/go/_category/all.php>miejscu</a></u></b>",
                'export'=>"Eksportuj  produkty ze sklepu do <b>interia Pasa�</b>.",
                'submit'=>"Eksport produkt�w",
                'noproduct'=>"Brak produkt�w do exportu",
                );
$lang->interia_category=array(
                'info'=>"interia Pasa� posiada w�asne drzewo kategorii. �eby korzysta� z kategorii interia Pasa� oraz
				kwalifikowa� produkty sklepowe do kategorii interia Pasa�, nale�y do��czy� te kategorie do sklepu 
				Przyporz�dkowa� produkt ze skelpu do kategorii z interia Pasa� mo�esz zrobic w tym <b><u><a href=/go/_category/all.php>miejscu</a></u></b>",
                'category'=>"Pobra� kategorie <b>interia Pasa�</b> do sklepu.",
                'submit'=>"Pobierz dane",
                );
?>