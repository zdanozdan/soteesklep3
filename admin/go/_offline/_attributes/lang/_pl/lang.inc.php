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
                'no_user_id'=>"W bazie nie ma produktu dla ktorego chcesz za³adowaæ atrybuty.",
                'file_error'=>"Nieprawid³owy format pliku. Program nie znalaz³ w pliku prawid³owych rekordów. Prosze stworzyæ plik zgodny z przyk³adem, który mo¿na znale¼æ w zak³adce\"",
                );
$lang->offline_load_errors=array(
                'not_user_id'=>"Je¶li aktualizujemy rekord jednym z pól musi byæ user_id",
                );
$lang->offline_check_errors=array(
                'id_main'=>"Brak pola id_main lub nieprawid³owy format",
                'attribute1'=>"Brak atrybutu 1",
                );
$lang->offline_category_error=array(
                'category1_load'=>"Nastapi³ b³±d podczas ³adowania kategorii do bazy danych",
                );
$lang->offline_update="Aktualizacja atrybutów";
$lang->offline_update_ok="Atrybuty zosta³y za³adowane poprawnie";
$lang->offline_update_error="<font color=red><b> ERROR!!!</b></font> Podczas ³adowania atrybutów nastapi³y b³êdy. Kliknij w zak³adkê 
<b>Status</b> ¿eby zobaczyæ informacje o b³êdach.";
$lang->offline_money=array(
                '50'=>"£aduje ca³± listê",
                '20'=>"Piny za 20z³",
                '10'=>"Piny na 10z³",
                );
$lang->offline_legend=array(
                'green'=>"Rekord za³adowany poprawnie do bazy",
                'blue'=>"B³±d podczas weryfikacji danych",
                'red'=>"B³±d podczas ³adowania danych do bazy",
                'fiol'=>"Rekordy zignorowane ze wzglêdu na ograniczenia w tej wersji sklepu",
                'sel'=>"Inne b³êdy",
                'info'=>"Legenda",
                );
$lang->offline_menu=array(
                'load'=>"£aduj atrybuty",
                'update'=>"Aktualizuj",
                'status'=>"Status",
                'examples'=>"Przyk³adowy plik z atrybutami",
                'export'=>"Eksport danych do sklepu",
                'doc'=>"Dokumentacja",
                'help'=>"Pomoc",
                );
$lang->offline_upload_info="Za³±cz plik z atrybutami. Plik powinien zawieraæ przynajmniej dwie kolumny.";
$lang->offline_load_all="£adujê wszystkie atrybuty";
$lang->offline_update_action="Aktualizujê atrybuty";
$lang->offline_continue="Dokoñcz przerwan± aktualizacjê";
$lang->offline_sql_info="<B> UWAGA!</B><BR>Baza zostanie wype³niona danymi z
<a href=/go/_offline/_attributes/index.php><B><u>za³adowanego pliku.  </u></b></a>i";
$lang->offline_doc="Dokumentacja do modu³u atrybutów";
$lang->offline_submit_data="Aktualizuj dane";
$lang->offline_examples_price_list="¦ci±gnij przyk³adowy plik z atrybutami:<ul>
<li> <a href=data/attributes_excel.txt>Atrybuty</a>";
$lang->offline_examples_doc="¦ci±gnij  plik z dokumentacj±:<ul>
<li> <a href=data/attributes.pdf>Dokumentacja modu³u atrybutów</a>";
$lang->offline_update_errors="B³êdy wygenerowane podczas ostatniej aktualizacji:";
$lang->offline_date="Data";
$lang->offline_record="Rekord";
$lang->offline_record_info="Komunikat";
$lang->offline_field="Pole";
$lang->offline_product_update_info="Aktualizacja atrybutów:";
$lang->offline_no_file="<font color=red>UWAGA !!! Plik nie zosta³ za³adowany na serwer.</font>";
$lang->offline_size="<font color=red>UWAGA!!!</font> Rozmiar pliku który zosta³ za³adoany na serwer jest równy 0. 
Je¶li plik który za³±cza³e¶ nie jest pusty oznacza to, ¿e nast±pi³y b³êdy podczas przesy³ania pliku na serwer.";
$lang->offline_record_added="Rekordów dodanych";
$lang->offline_record_updated="Rekordów zaktualizowanych";
$lang->offline_record_deleted="Rekordów skasowanych";
$lang->attributes_export="Eksport atrybutow";
$lang->attributes_export_ok="Eksport atrybutow zakonczony pomyslnie";
$lang->offline_no_error="Nie wyst±pi³y ¿adne b³êdy podczas ³adowania danych do bazy";
?>