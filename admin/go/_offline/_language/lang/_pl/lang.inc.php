<?php
$lang->offline_file_errors=array(
                'not_open'=>"Nie uda³o siê otworzyæ pliku z danymi",
                'less'=>"W rekodzie jest mniej pól ni¿ w strukturze do której ³adujemy dane",
                'more'=>"W rekodzie jest wiêcej pól ni¿ w strukturze do której ³adujemy dane",
                'load_ignore'=>"Rekord nie zosta³ za³adowany ze wzglêdu na limit produktów w tej wersji sklepu",
                'load_database'=>"Wystapi³ b³ad podczas ³adowania rekrodu do bazy danych",
                'error_update'=>"Próba aktualizacji rekordu którego nie ma w bazie",
                'error_insert'=>"Próba dodania rekordu który ju¿ istnieje w bazie",
                'error_delete'=>"Próba skasowania rekordu którego nie ma w bazie",
                'error_struct'=>"<font color=red>ERROR !!! </font>Plik ma nieprawidlow± strukture. Plik nie zosta³ za³adowany",
                'error_file'=>"Brak pliku - ",
                'no_record'=>"Rekord o podanym user_id nie istnieje w bazie danych",
                );
$lang->offline_load_errors=array(
                'not_user_id'=>"Je¶li aktualizujemy rekord jednym z pól musi byæ user_id",
                );
$lang->offline_check_errors=array(
                /*'command'=>array(
                                '1'=>"Brak informacji o tym co zrobiæ z rekordem. Pole powinno zawieraæ jedn± z liter A U D",
                                '2'=>"Pole zawiera znak ró¿ny id A U D",
                                ),
                                
                'photo'=>array(
                                '1'=>"Brak nazwy zdjêcia",
                                '2'=>"Zdjêcie nie jest w formacie GIF JPG lub PNG",
                                ),
                  */              
                'user_id'=>"Brak pola user_id lub nieprawid³owy format",
                'name'=>"Brak nazwy lub nazwa nieprawid³owa",
                'price_brutto'=>"Nieprawid³owy format ceny",
                /*'promotion'=>"Pole promocje mo¿e przyjmowaæ warto¶ci 0 1 lub mo¿e byæ puste",
                'newcol'=>"Pole newcol mo¿e przyjmowaæ warto¶ci 0 1 lub mo¿e byæ puste",
                'bestseller'=>"Pole bestseller mo¿e przyjmowaæ warto¶ci 0 1 lub mo¿e byæ puste",*/
                );
                
$lang->offline_category_error=array(
                'category1_load'=>"Nastapi³ b³±d podczas ³adowania kategorii do bazy danych",
                );
$lang->offline_update="Aktualizacja opisów w innych jêzykach";
$lang->offline_update_ok="Cennik zosta³ za³adowany poprawnie";
$lang->offline_update_ok_but="<font color=red> ale podczas procesu nastapi³y b³edy</font>.Kliknij w zak³adkê <b>Status</b> ¿eby zobaczyæ informacje o b³êdach.";
$lang->offline_update_error="Podczas ³adowania cennika nastapi³y b³êdy. Kliknij w zak³adkê <b>Status</b> ¿eby zobaczyæ informacje o b³êdach.";
$lang->offline_legend=array(
                'green'=>"Rekord za³adowany poprawnie do bazy",
                'blue'=>"B³±d podczas weryfikacji danych",
                'red'=>"B³±d podczas ³adowania danych do bazy",
                'fiol'=>"Rekordy zignorowane ze wzglêdu na ograniczenia w tej wersji sklepu",
                'sel'=>"Inne b³êdy",
                'info'=>"Legenda",
                );
$lang->offline_menu=array(
                'load'=>"£aduj opisy w innych jêzykach",
                'update'=>"Aktualizuj",
                'status'=>"Status",
                'examples'=>"Przyk³adowe plik jêzykowy",
                'config'=>"Konfiguracja",
                'help'=>"Pomoc",
                'export'=>"Export opisów",
                );
$lang->offline_upload_info="Za³±cz plik z opisami w innych jêzykach zgodnie z plikiem przyk³adowym. Zapisz plik w formacie CSV u¿ywaj±c znaku tabulacji jako separatora.";
$lang->offline_load_all="£adujê ca³y cennik";
$lang->offline_update_action="Aktualizujê informacje o produktach";
$lang->offline_continue="Dokoñcz przerwan± aktualizacjê";
$lang->offline_sql_info="Baza zostanie uzupe³niona informacjami o produktach w innych jêzykach ";
$lang->offline_submit_data="Aktualizuj dane";
$lang->offline_examples_price_list="¦ci±gnij przyk³adowy plik cennika:<ul>
<li> <a href=data/lang_pl.csv>TXT </a>
</ul>Cenniki w formacie sdc,xls i dbf wymagaj± przekonwertowania plików na format txt przy 
u¿yciu programów StarOffice, OpenOffice lub Excel.";
$lang->offline_update_errors="B³êdy wygenerowane podczas ostatniej aktualizacji:";
$lang->offline_date="Data";
$lang->offline_record="Rekord";
$lang->offline_record_info="Komunikat";
$lang->offline_field="Pole";
$lang->offline_product_update_info="Aktualizcja bazy produktów sklepu:";
$lang->offline_no_file="<font color=red>UWAGA! Plik z cennikiem nie zosta³ za³±czony.</font>";
$lang->offline_size="<font color=red>UWAGA!!!</font> Rozmiar pliku który zosta³ za³adowany na serwer jest równy 0. 
Je¶li plik który za³±cza³e¶ nie jest pusty oznacza to, ¿e nast±pi³y b³êdy podczas przesy³ania pliku na serwer. 
Spróbuj jeszcze raz przes³aæ plik.";
$lang->offline_record_added="Rekordów dodanych";
$lang->offline_record_updated="Rekordów zaktualizowanych";
$lang->offline_record_deleted="Rekordów skasowanych";
$lang->offline_config=array(
                'option'=>"Opcje aktualizacji",
                'type_file'=>"Typ importowanego pliku",
                'main_table'=>"Nazwa tablicy",
                );
$lang->offline_no_error="Nie wyst±pi³y ¿adne b³êdy podczas ³adowania danych do bazy";
$lang->offline_names_column=array(
                'user_id'=>"ID produktu",
                'price_brutto'=>"Cena brutto",
                'xml_description'=>"Pe³ny opis produktu",
                'xml_short_description'=>"Krótki opis produktu",
                'photo'=>"Fotografia produktu",
                'flash'=>"Fotografia Flash",
                'flash_html'=>"Kod fotografi flash",
                'pdf'=>"Fotografia PDF",
                'xml_options'=>"Opcje do produktu",
                'promotion'=>"Produkty promocyjne",
                'newcol'=>"Nowo¶æ",
                'bestseller'=>"Bestseller",
                'main_page'=>"Strona g³ówna",
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
                'id_available'=>"Dostêpno¶æ",
                'price_brutto_2'=>"Cena hurtowa",
                'hidden_price'=>"Nie pokazuj ceny",
                'discount'=>"Rabat",
                'accessories'=>"Akcesoria",
                'price_currency'=>"Cena w walucie",
                'max_discount'=>"Max Rabat",
                'onet_category'=>"Kategoria OnetPasa¿",
                'onet_export'=>"Export OnetPasa¿",
                'onet_status'=>"Status OnetPasa¿",
                'onet_image_export'=>"Obrazek Export OnetPasa¿",
                'onet_image_desc'=>"Obrazek opis OnetPasa¿",
                'onet_image_title'=>"Obrazek tytu³ OnetPasa¿",
                'onet_attrib'=>"Atrybuty OnetPasa¿",
                'google_title'=>"Google tytu³",
                'google_keywords'=>"Google s³owa",
                'google_description'=>"Google opis",
                'category_multi_1'=>"Produkt w kategorii 2",
                'category_multi_2'=>"Produkt w kategorii 3",
               	'ask4price'=>"Zapytaj o cenê",
                );
?>