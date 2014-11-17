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
                'no_user_id'=>"W bazie nie ma produktu dla ktorego chcesz za�adowa� atrybuty.",
                'file_error'=>"Nieprawid�owy format pliku. Program nie znalaz� w pliku prawid�owych rekord�w. Prosze stworzy� plik zgodny z przyk�adem, kt�ry mo�na znale�� w zak�adce\"",
                );
$lang->offline_load_errors=array(
                'not_user_id'=>"Je�li aktualizujemy rekord jednym z p�l musi by� user_id",
                );
$lang->offline_check_errors=array(
                'id_main'=>"Brak pola id_main lub nieprawid�owy format",
                'attribute1'=>"Brak atrybutu 1",
                );
$lang->offline_category_error=array(
                'category1_load'=>"Nastapi� b��d podczas �adowania kategorii do bazy danych",
                );
$lang->offline_update="Aktualizacja atrybut�w";
$lang->offline_update_ok="Atrybuty zosta�y za�adowane poprawnie";
$lang->offline_update_error="<font color=red><b> ERROR!!!</b></font> Podczas �adowania atrybut�w nastapi�y b��dy. Kliknij w zak�adk� 
<b>Status</b> �eby zobaczy� informacje o b��dach.";
$lang->offline_money=array(
                '50'=>"�aduje ca�� list�",
                '20'=>"Piny za 20z�",
                '10'=>"Piny na 10z�",
                );
$lang->offline_legend=array(
                'green'=>"Rekord za�adowany poprawnie do bazy",
                'blue'=>"B��d podczas weryfikacji danych",
                'red'=>"B��d podczas �adowania danych do bazy",
                'fiol'=>"Rekordy zignorowane ze wzgl�du na ograniczenia w tej wersji sklepu",
                'sel'=>"Inne b��dy",
                'info'=>"Legenda",
                );
$lang->offline_menu=array(
                'load'=>"�aduj atrybuty",
                'update'=>"Aktualizuj",
                'status'=>"Status",
                'examples'=>"Przyk�adowy plik z atrybutami",
                'export'=>"Eksport danych do sklepu",
                'doc'=>"Dokumentacja",
                'help'=>"Pomoc",
                );
$lang->offline_upload_info="Za��cz plik z atrybutami. Plik powinien zawiera� przynajmniej dwie kolumny.";
$lang->offline_load_all="�aduj� wszystkie atrybuty";
$lang->offline_update_action="Aktualizuj� atrybuty";
$lang->offline_continue="Doko�cz przerwan� aktualizacj�";
$lang->offline_sql_info="<B> UWAGA!</B><BR>Baza zostanie wype�niona danymi z
<a href=/go/_offline/_attributes/index.php><B><u>za�adowanego pliku.  </u></b></a>i";
$lang->offline_doc="Dokumentacja do modu�u atrybut�w";
$lang->offline_submit_data="Aktualizuj dane";
$lang->offline_examples_price_list="�ci�gnij przyk�adowy plik z atrybutami:<ul>
<li> <a href=data/attributes_excel.txt>Atrybuty</a>";
$lang->offline_examples_doc="�ci�gnij  plik z dokumentacj�:<ul>
<li> <a href=data/attributes.pdf>Dokumentacja modu�u atrybut�w</a>";
$lang->offline_update_errors="B��dy wygenerowane podczas ostatniej aktualizacji:";
$lang->offline_date="Data";
$lang->offline_record="Rekord";
$lang->offline_record_info="Komunikat";
$lang->offline_field="Pole";
$lang->offline_product_update_info="Aktualizacja atrybut�w:";
$lang->offline_no_file="<font color=red>UWAGA !!! Plik nie zosta� za�adowany na serwer.</font>";
$lang->offline_size="<font color=red>UWAGA!!!</font> Rozmiar pliku kt�ry zosta� za�adoany na serwer jest r�wny 0. 
Je�li plik kt�ry za��cza�e� nie jest pusty oznacza to, �e nast�pi�y b��dy podczas przesy�ania pliku na serwer.";
$lang->offline_record_added="Rekord�w dodanych";
$lang->offline_record_updated="Rekord�w zaktualizowanych";
$lang->offline_record_deleted="Rekord�w skasowanych";
$lang->attributes_export="Eksport atrybutow";
$lang->attributes_export_ok="Eksport atrybutow zakonczony pomyslnie";
$lang->offline_no_error="Nie wyst�pi�y �adne b��dy podczas �adowania danych do bazy";
?>