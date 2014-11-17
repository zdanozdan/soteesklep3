<?php
$lang->offline_file_errors=array(
                'not_open'=>'Nie uda³o siê otworzyæ pliku z danymi',
                'less'=>'W rekodzie jest mniej pól ni¿ w strukturze do której ³adujemy dane',
                'more'=>'W rekodzie jest wiêcej pól ni¿ w strukturze do której ³adujemy dane',
                'load_ignore'=>'Rekord nie zosta³ za³adowany ze wzglêdu na limit produktów w tej wersji sklepu',
                'load_database'=>'Wystapi³ b³ad podczas ³adowania rekrodu do bazy danych',
                'error_update'=>'Próba aktualizacji rekordu którego nie ma w bazie',
                'error_insert'=>'Próba dodania rekordu który ju¿ istnieje w bazie',
                'error_delete'=>'Próba skasowania rekordu którego nie ma w bazie',
                );
$lang->offline_load_errors=array(
                'not_user_id'=>'Je¶li aktualizujemy rekord jednym z pól musi byæ user_id',
                );
$lang->offline_check_errors=array(
                'user_id_main'=>'Probujesz zaladowac piny o innym nominale niz zaznaczyles',
                'main_key'=>array(
                                '1'=>'Pin zawiera inne znaki ni¿ cyfry',
                                '2'=>'Pin jest za krótki',
                                '3'=>'Pin jest za d³ugi',
                                ),
                                
                );
$lang->offline_category_error=array(
                'category1_load'=>'Nastapi³ b³±d podczas ³adowania kategorii do bazy danych',
                );
$lang->offline_update="Aktualizacja cennika";
$lang->offline_update_ok="Cennik zosta³ za³adowany poprawnie";
$lang->offline_update_error="<font color=red><b> ERROR!!!</b></font> Podczas ³adowania cennika nastapi³y b³êdy. Kliknij w zak³adkê <b>Status</b> ¿eby zobaczyæ informacje o b³êdach.";
$lang->offline_money=array(
                '50'=>'Piny za 50z³',
                '20'=>'Piny za 20z³',
                '10'=>'Piny na 10z³',
                );
$lang->offline_legend=array(
                'green'=>'Rekord za³adowany poprawnie do bazy',
                'blue'=>'B³±d podczas weryfikacji danych',
                'red'=>'B³±d podczas ³adowania danych do bazy',
                'fiol'=>'Rekordy zignorowane ze wzglêdu na ograniczenia w tej wersji sklepu',
                'sel'=>'Inne b³êdy',
                'info'=>'Legenda',
                );
$lang->offline_menu=array(
                'load'=>'£aduj piny',
                'update'=>'Aktualizuj',
                'status'=>'Status',
                'examples'=>'Przyk³adowe piny',
                );
$lang->offline_upload_info="Za³±cz plik z pinami. Plik powinien zawieraæ dwie kolumny gdzie w pierwszej znajduje siê nomina³ a w drugiej PIN.";
$lang->offline_load_all="£adujê ca³y cennik";
$lang->offline_update_action="Aktualizujê cennik";
$lang->offline_continue="Dokoñcz przerwan± aktualizacjê";
$lang->offline_sql_info="<B> UWAGA!</B><BR>Baza zostanie uzupe³niona pinamy z
<a href=/go/_offline/_piny/index.php><B><u>za³adowanego
 pliku.  </u></b></a>";
$lang->offline_submit_data="Aktualizuj dane";
$lang->offline_examples_price_list="¦ci±gnij przyk³adowy plik z pinami:<ul>
<li> <a href=data/piny10zl.csv>Piny za 10 z³ </a>
<li> <a href=data/piny20zl.csv>Piny za 20 z³ </a>
<li> <a href=data/piny50zl.csv>Piny za 50 z³ </a>";
$lang->offline_update_errors="B³êdy wygenerowane podczas ostatniej aktualizacji:";
$lang->offline_date="Data";
$lang->offline_record="Rekord";
$lang->offline_record_info="Komunikat";
$lang->offline_field="Pole";
$lang->offline_product_update_info="Aktualizcja bazy produktów sklepu:";
$lang->offline_no_file="<font color=red>UWAGA !!! </font>Plik nie zosta³ prawid³owo za³adowany na serwer. 
Spróbuj jeszcze raz a je¶li pojawi sie taki sam komunikat 
skontatuj siê z administratorem.
<p>
<ul>
 <li> Je¶li chcesz zaktualizowaæ bazê produktów wybierz zak³adkê <a href=/go/_offline/_main/><u>cennik</u></a>
 <li> Je¶li chcesz wprowadziæ listê z atrybutami dla produktów wybierz
 zak³adkê <a href=/go/_offline/_attributes/><u>atrybuty</u></a>
 <li> UWAGA! Je¶li aktualizujesz cennik i  atrybuty, to musisz pamiêtaæ o
 kolejno¶ci aktualizacji. W pierwszej kolejno¶ci wprowadziæ nale¿y nowy cennik
 po¼niej listê nowych atrybutów.
</ul>";
$lang->offline_size="<font color=red>UWAGA!!!</font> Rozmiar pliku który zosta³ za³adowany na serwer jest równy 0. 
Je¶li plik który za³±cza³e¶ nie jest pusty oznacza to, ¿e nast±pi³y b³êdy podczas przesy³ania pliku na serwer. 
Spróbuj jeszcze raz przes³aæ plik. Je¶li ta informacja pojawi siê ponownie skontaktuj siê z administratorem. 
<p>
<ul>
 <li> Je¶li chcesz zaktualizowaæ bazê produktów wybierz zak³adkê <a href=/go/_offline/_main/><u>cennik</u></a>
 <li> Je¶li chcesz wprowadziæ listê z atrybutami dla produktów wybierz
 zak³adkê <a href=/go/_offline/_attributes/><u>atrybuty</u></a>
 <li> UWAGA! Je¶li aktualizujesz cennik i  atrybuty, to musisz pamiêtaæ o
 kolejno¶ci aktualizacji. W pierwszej kolejno¶ci wprowadziæ nale¿y nowy cennik
 po¼niej listê nowych atrybutów.
</ul>/=/";
$lang->offline_record_added="Rekordów dodanych";
$lang->offline_record_updated="Rekordów zaktualizowanych";
$lang->offline_record_deleted="Rekordów skasowanych";
?>