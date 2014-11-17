<?php
$lang->offline_file_errors=array(
                'not_open'=>'Nie uda�o si� otworzy� pliku z danymi',
                'less'=>'W rekodzie jest mniej p�l ni� w strukturze do kt�rej �adujemy dane',
                'more'=>'W rekodzie jest wi�cej p�l ni� w strukturze do kt�rej �adujemy dane',
                'load_ignore'=>'Rekord nie zosta� za�adowany ze wzgl�du na limit produkt�w w tej wersji sklepu',
                'load_database'=>'Wystapi� b�ad podczas �adowania rekrodu do bazy danych',
                'error_update'=>'Pr�ba aktualizacji rekordu kt�rego nie ma w bazie',
                'error_insert'=>'Pr�ba dodania rekordu kt�ry ju� istnieje w bazie',
                'error_delete'=>'Pr�ba skasowania rekordu kt�rego nie ma w bazie',
                );
$lang->offline_load_errors=array(
                'not_user_id'=>'Je�li aktualizujemy rekord jednym z p�l musi by� user_id',
                );
$lang->offline_check_errors=array(
                'user_id_main'=>'Probujesz zaladowac piny o innym nominale niz zaznaczyles',
                'main_key'=>array(
                                '1'=>'Pin zawiera inne znaki ni� cyfry',
                                '2'=>'Pin jest za kr�tki',
                                '3'=>'Pin jest za d�ugi',
                                ),
                                
                );
$lang->offline_category_error=array(
                'category1_load'=>'Nastapi� b��d podczas �adowania kategorii do bazy danych',
                );
$lang->offline_update="Aktualizacja cennika";
$lang->offline_update_ok="Cennik zosta� za�adowany poprawnie";
$lang->offline_update_error="<font color=red><b> ERROR!!!</b></font> Podczas �adowania cennika nastapi�y b��dy. Kliknij w zak�adk� <b>Status</b> �eby zobaczy� informacje o b��dach.";
$lang->offline_money=array(
                '50'=>'Piny za 50z�',
                '20'=>'Piny za 20z�',
                '10'=>'Piny na 10z�',
                );
$lang->offline_legend=array(
                'green'=>'Rekord za�adowany poprawnie do bazy',
                'blue'=>'B��d podczas weryfikacji danych',
                'red'=>'B��d podczas �adowania danych do bazy',
                'fiol'=>'Rekordy zignorowane ze wzgl�du na ograniczenia w tej wersji sklepu',
                'sel'=>'Inne b��dy',
                'info'=>'Legenda',
                );
$lang->offline_menu=array(
                'load'=>'�aduj piny',
                'update'=>'Aktualizuj',
                'status'=>'Status',
                'examples'=>'Przyk�adowe piny',
                );
$lang->offline_upload_info="Za��cz plik z pinami. Plik powinien zawiera� dwie kolumny gdzie w pierwszej znajduje si� nomina� a w drugiej PIN.";
$lang->offline_load_all="�aduj� ca�y cennik";
$lang->offline_update_action="Aktualizuj� cennik";
$lang->offline_continue="Doko�cz przerwan� aktualizacj�";
$lang->offline_sql_info="<B> UWAGA!</B><BR>Baza zostanie uzupe�niona pinamy z
<a href=/go/_offline/_piny/index.php><B><u>za�adowanego
 pliku.  </u></b></a>";
$lang->offline_submit_data="Aktualizuj dane";
$lang->offline_examples_price_list="�ci�gnij przyk�adowy plik z pinami:<ul>
<li> <a href=data/piny10zl.csv>Piny za 10 z� </a>
<li> <a href=data/piny20zl.csv>Piny za 20 z� </a>
<li> <a href=data/piny50zl.csv>Piny za 50 z� </a>";
$lang->offline_update_errors="B��dy wygenerowane podczas ostatniej aktualizacji:";
$lang->offline_date="Data";
$lang->offline_record="Rekord";
$lang->offline_record_info="Komunikat";
$lang->offline_field="Pole";
$lang->offline_product_update_info="Aktualizcja bazy produkt�w sklepu:";
$lang->offline_no_file="<font color=red>UWAGA !!! </font>Plik nie zosta� prawid�owo za�adowany na serwer. 
Spr�buj jeszcze raz a je�li pojawi sie taki sam komunikat 
skontatuj si� z administratorem.
<p>
<ul>
 <li> Je�li chcesz zaktualizowa� baz� produkt�w wybierz zak�adk� <a href=/go/_offline/_main/><u>cennik</u></a>
 <li> Je�li chcesz wprowadzi� list� z atrybutami dla produkt�w wybierz
 zak�adk� <a href=/go/_offline/_attributes/><u>atrybuty</u></a>
 <li> UWAGA! Je�li aktualizujesz cennik i  atrybuty, to musisz pami�ta� o
 kolejno�ci aktualizacji. W pierwszej kolejno�ci wprowadzi� nale�y nowy cennik
 po�niej list� nowych atrybut�w.
</ul>";
$lang->offline_size="<font color=red>UWAGA!!!</font> Rozmiar pliku kt�ry zosta� za�adowany na serwer jest r�wny 0. 
Je�li plik kt�ry za��cza�e� nie jest pusty oznacza to, �e nast�pi�y b��dy podczas przesy�ania pliku na serwer. 
Spr�buj jeszcze raz przes�a� plik. Je�li ta informacja pojawi si� ponownie skontaktuj si� z administratorem. 
<p>
<ul>
 <li> Je�li chcesz zaktualizowa� baz� produkt�w wybierz zak�adk� <a href=/go/_offline/_main/><u>cennik</u></a>
 <li> Je�li chcesz wprowadzi� list� z atrybutami dla produkt�w wybierz
 zak�adk� <a href=/go/_offline/_attributes/><u>atrybuty</u></a>
 <li> UWAGA! Je�li aktualizujesz cennik i  atrybuty, to musisz pami�ta� o
 kolejno�ci aktualizacji. W pierwszej kolejno�ci wprowadzi� nale�y nowy cennik
 po�niej list� nowych atrybut�w.
</ul>/=/";
$lang->offline_record_added="Rekord�w dodanych";
$lang->offline_record_updated="Rekord�w zaktualizowanych";
$lang->offline_record_deleted="Rekord�w skasowanych";
?>