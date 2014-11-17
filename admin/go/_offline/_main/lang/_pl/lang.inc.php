<?php
$lang->offline_file_errors=array(
                'not_open'=>"Nie uda�o si� otworzy� pliku z danymi",
                'less'=>"W rekodzie jest mniej p�l ni� w strukturze do kt�rej �adujemy dane",
                'more'=>"W rekodzie jest wi�cej p�l ni� w strukturze do kt�rej �adujemy dane",
                'load_ignore'=>"Rekord nie zosta� za�adowany ze wzgl�du na limit produkt�w w tej wersji sklepu",
                'load_database'=>"Wystapi� b�ad podczas �adowania rekrodu do bazy danych",
                'error_update'=>"Pr�ba aktualizacji rekordu kt�rego nie ma w bazie",
                'error_insert'=>"Pr�ba dodania rekordu kt�ry ju� istnieje w bazie",
                'error_delete'=>"Pr�ba skasowania rekordu kt�rego nie ma w bazie",
                'error_struct'=>"<font color=red>ERROR !!! </font>Plik ma nieprawidlow� strukture. Plik nie zosta� za�adowany",
                'error_file'=>"Brak pliku - ",
                'no_record'=>"Rekord o podanym user_id nie istnieje w bazie danych",
                );
$lang->offline_load_errors=array(
                'not_user_id'=>"Je�li aktualizujemy rekord jednym z p�l musi by� user_id",
                );
$lang->offline_check_errors=array(
                /*'command'=>array(
                                '1'=>"Brak informacji o tym co zrobi� z rekordem. Pole powinno zawiera� jedn� z liter A U D",
                                '2'=>"Pole zawiera znak r�ny id A U D",
                                ),
                                
                'photo'=>array(
                                '1'=>"Brak nazwy zdj�cia",
                                '2'=>"Zdj�cie nie jest w formacie GIF JPG lub PNG",
                                ),
                  */              
                'user_id'=>"Brak pola user_id lub nieprawid�owy format",
                'name'=>"Brak nazwy lub nazwa nieprawid�owa",
                'price_brutto'=>"Nieprawid�owy format ceny",
                /*'promotion'=>"Pole promocje mo�e przyjmowa� warto�ci 0 1 lub mo�e by� puste",
                'newcol'=>"Pole newcol mo�e przyjmowa� warto�ci 0 1 lub mo�e by� puste",
                'bestseller'=>"Pole bestseller mo�e przyjmowa� warto�ci 0 1 lub mo�e by� puste",*/
                );
                
$lang->offline_category_error=array(
                'category1_load'=>"Nastapi� b��d podczas �adowania kategorii do bazy danych",
                );
$lang->offline_update="Aktualizacja cennika";
$lang->offline_update_ok="Cennik zosta� za�adowany poprawnie";
$lang->offline_update_ok_but="<font color=red> ale podczas procesu nastapi�y b�edy</font>.Kliknij w zak�adk� <b>Status</b> �eby zobaczy� informacje o b��dach.";
$lang->offline_update_error="Podczas �adowania cennika nastapi�y b��dy. Kliknij w zak�adk� <b>Status</b> �eby zobaczy� informacje o b��dach.";
$lang->offline_legend=array(
                'green'=>"Rekord za�adowany poprawnie do bazy",
                'blue'=>"B��d podczas weryfikacji danych",
                'red'=>"B��d podczas �adowania danych do bazy",
                'fiol'=>"Rekordy zignorowane ze wzgl�du na ograniczenia w tej wersji sklepu",
                'sel'=>"Inne b��dy",
                'info'=>"Legenda",
                );
$lang->offline_menu=array(
                'load'=>"�aduj cennik",
                'update'=>"Aktualizuj",
                'status'=>"Status",
                'examples'=>"Przyk�adowe cenniki",
                'config'=>"Konfiguracja",
                'help'=>"Pomoc",
                );
$lang->offline_money=array(
                '50'=>"Piny za 50z�",
                '20'=>"Piny za 20z�",
                '10'=>"Piny na 10z�",
                );
$lang->offline_upload_info="Za��cz plik z cennikiem. Zapisz plik z Excela z tabulatoram jako separator.";
$lang->offline_load_all="�aduj� ca�y cennik";
$lang->offline_update_action="Aktualizuj� cennik";
$lang->offline_continue="Doko�cz przerwan� aktualizacj�";
$lang->offline_sql_info="<B> UWAGA!</B><BR>Baza zostanie skasowana i zast�piona danymi z 
<a href=/go/_offline/index.php><B><u>za�adowanego  pliku cennika. </u></b></a><BR>Po aktualizacji nale�y wywo�a� 
<a href=/go/_opt/><B><u>optymalizacj�</u></B></a> w celu uaktualnienia danych kategorii.";
$lang->offline_submit_data="Aktualizuj dane";
$lang->offline_examples_price_list="�ci�gnij przyk�adowy plik cennika:<ul>
<li> <a href=data/soteesklep_pl.csv>TXT </a>
</ul>Cenniki w formacie sdc,xls i dbf wymagaj� przekonwertowania plik�w na format txt przy 
u�yciu program�w StarOffice, OpenOffice lub Excel.";
$lang->offline_update_errors="B��dy wygenerowane podczas ostatniej aktualizacji:";
$lang->offline_date="Data";
$lang->offline_record="Rekord";
$lang->offline_record_info="Komunikat";
$lang->offline_field="Pole";
$lang->offline_product_update_info="Aktualizcja bazy produkt�w sklepu:";
$lang->offline_no_file="<font color=red>UWAGA! Plik z cennikiem nie zosta� za��czony.</font>";
$lang->offline_size="<font color=red>UWAGA!!!</font> Rozmiar pliku kt�ry zosta� za�adowany na serwer jest r�wny 0. 
Je�li plik kt�ry za��cza�e� nie jest pusty oznacza to, �e nast�pi�y b��dy podczas przesy�ania pliku na serwer. 
Spr�buj jeszcze raz przes�a� plik.";
$lang->offline_record_added="Rekord�w dodanych";
$lang->offline_record_updated="Rekord�w zaktualizowanych";
$lang->offline_record_deleted="Rekord�w skasowanych";
$lang->offline_config=array(
                'option'=>"Opcje aktualizacji",
                'type_file'=>"Typ importowanego pliku",
                'main_table'=>"Nazwa tablicy",
                );
$lang->offline_no_error="Nie wyst�pi�y �adne b��dy podczas �adowania danych do bazy";
$lang->offline_names_column=array(
                'user_id'=>"ID produktu",
                'price_brutto'=>"Cena brutto",
                'xml_description'=>"Pe�ny opis produktu",
                'xml_short_description'=>"Kr�tki opis produktu",
                'photo'=>"Fotografia produktu",
                'flash'=>"Fotografia Flash",
                'flash_html'=>"Kod fotografi flash",
                'pdf'=>"Fotografia PDF",
                'xml_options'=>"Opcje do produktu",
                'promotion'=>"Produkty promocyjne",
                'newcol'=>"Nowo��",
                'bestseller'=>"Bestseller",
                'main_page'=>"Strona g��wna",
                'active'=>"Aktywny",
                'name'=>"Nazwa produktu",
                'producer'=>"Producent",
                'category1'=>"Kategoria 1",
                'category2'=>"Kategoria 2",
                'category3'=>"Kategoria 3",
                'category4'=>"Kategoria 4",
                'category5'=>"Kategoria 5",
                'id_currency'=>"Waluta",
                'vat'=>"Stawka VAT",
                'price_brutto_detal'=>"Stara Cena",
                'id_available'=>"Dost�pno��",
                'price_brutto_2'=>"Cena hurtowa",
                'hidden_price'=>"Nie pokazuj ceny",
                'discount'=>"Rabat",
                'accessories'=>"Akcesoria",
                'price_currency'=>"Cena w walucie",
                'max_discount'=>"Max Rabat",
                'onet_category'=>"Kategoria OnetPasa�",
                'onet_export'=>"Export OnetPasa�",
                'onet_status'=>"Status OnetPasa�",
                'onet_image_export'=>"Obrazek Export OnetPasa�",
                'onet_image_desc'=>"Obrazek opis OnetPasa�",
                'onet_image_title'=>"Obrazek tytu� OnetPasa�",
                'onet_attrib'=>"Atrybuty OnetPasa�",
                'google_title'=>"Google tytu�",
                'google_keywords'=>"Google s�owa",
                'google_description'=>"Google opis",
                'category_multi_1'=>"Produkt w kategorii 2",
                'category_multi_2'=>"Produkt w kategorii 3",
                'ask4price'=>"Zapytaj o cen�",
                );
?>