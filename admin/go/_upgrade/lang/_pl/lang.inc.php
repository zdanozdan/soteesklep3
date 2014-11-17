<?php
$lang->upgrade_updates="Instaluj uaktualnienia";
$lang->upgrade_check_new="Sprawd¼ dostêpne aktualizacje";
$lang->upgrade_title="Automatyczna aktualizacja programu";
$lang->upgrade_get_info="Za³±cz aktualizacjê sklepu";
$lang->upgrade_file_uploaded="Plik aktualizacji pakietu zosta³ za³±czony: ";
$lang->upgrade_files="Lista zaktualizowanych plików";
$lang->upgrade_done="Aktualizacja zakoñczona";
$lang->upgrade_prev="Aktualizacje zainstalowane w sklepie";
$lang->upgrade_25_menu=array(
                'order'=>"Aktualizuj dane transakcji z wersji 2.5->3.0",
                'users'=>"Aktualizuj dane klientów z wersji 2.5->3.0",
                'themes'=>"Aktualizuj temat wersji 2.5->3.0",
                );
$lang->upgrade_25_done="Dane zosta³y zaktualizowane";
$lang->upgrade_25_error="Dane nie zosta³y zaktualizowane";
$lang->upgrade_25_description="Aktualizcja wersji 2.5->3.0";
$lang->upgrade_name_theme="Nazwa tematu do aktualizacji";
$lang->upgrade_file_status=array(
                '2'=>"Pominiêty. Wersja na dysku jest nowsza od wersji z aktualizacji.",
                '1'=>"Plik nie zosta³ zaktualizowany. Wykryto modyfikacjê.",
                '3'=>"Pominiêty. Plik z indywidualn± modyfikacj±.",
                '4'=>"Zatwierdzony w poprzedniej aktualizacji.",
                );
$lang->upgrade_file_status_simulation=array(
                '2'=>"Test: Zostanie Pominiêty. Wersja na dysku jest nowsza od wersji z aktualizacji.",
                '1'=>"Test: Wykryto modyfikacjê.",
                '3'=>"Test: Plik z indywidualn± modyfikacj±.",
                '4'=>"Test: Zatwierdzony w poprzedniej aktualizacji.",
                );
$lang->upgrade_checksums_upgraded="Baza sum kontrolnych programu zosta³a zaktualizowana.";
$lang->upgrade_checksums_upgrade_error="Nie uda³o siê zaktualizowaæ bazy sum kontrolnych.";
$lang->upgrade_pkg=array(
                '1.01'=>"Wprowad¼ do sklepu aktualizacjê oznaczon± numerem 30003. Jest to aktualizacja wymagana do instalowania kolejnych ulepszeñ w sklepie.",
                );
$lang->upgrade_nomd5_info="Brak bazy sum kontrolnych programu.";
$lang->upgrade_md5_install="Pobierz bazê";
$lang->upgrade_md5_installed="Baza sum kontrolnych zainstalowana.";
$lang->upgrade_md5_continue="Przejd¼ do systemu aktualizacji";
$lang->upgrade_to_install="Pakiety aktualizyjne dostêpne do zainstalowania (pakiety dostêpne na stronie <a href=http://serwis.sote.pl>http://serwis.sote.pl</a>)";
$lang->upgrade_check_new_version_title="Sprawdzenie dostêpnych aktualizacji";
$lang->upgrade_new_not_found="Aktualnie w sklepie zainstalowane s± wszystkie dostêpne, dla wersji {VERSION}, aktualizacje.<br /> Nie ma nowych aktualizacji.";
$lang->upgrade_database_updated="Baza danych zosta³a zaktualizowana.";
$lang->upgrade_diff_title="Automatyczne ³±czenie zmian w pliku ze zmianami z pakietu aktualizacyjnego";
$lang->upgrade_file_repair="Analizuj/Po³±cz zmiany";
$lang->upgrade_file_not_found="Brak danych plików";
$lang->upgrade_file=array(
                'path'=>"Wersja pliku na dysku",
                'upgrade'=>"Wersja pliku w pakiecie aktualizacyjnym",
                'diff'=>"<b>Plik z dysku z naniesionymi modyfikacjami z pakietu aktualizacyjnego</b>",
                );
$lang->upgrade_diff_file_upgraded="Plik zosta³ zapamiêtany i zostanie zainstalowany w obecnej sesji razem z instalacj± pakietu.<br />Uwaga! Po wylogowaniu siê, nale¿y powtórzyæ operacjê ³±czenia zmian.";
$lang->upgrade_diff_patch="Wykryte ró¿nice/podgl±d";
$lang->upgrade_unknown_gid="Brak numeru GID. Pliki graficzne nie zosta³y zaktualizowane.";
$lang->upgrade_individual_mod="indywidualna modyfikacja";
$lang->upgrade_files_list="Lista plików znajduj±cych siê w pakiecie aktualizacyjnym";
$lang->upgrade_files_simulation="Wynik probnej instalacji pakietu aktualizacyjnego. Weryfikacja sum kontrolnych.";
$lang->upgrade_error_ext="Nieprawid³owy format pakietu aktualizacyjnego.";
$lang->upgrade_wrong_format="Error: Brak numeru wersji pakietu. B³êdny format uaktualnienia.";
$lang->upgrade_already_installed="Pakiet jest ju¿ zainstalowany";
$lang->upgrade_devel_config="DEVEL: Konfiguracja";
$lang->upgrade_wrong_pkg_number="B³êdny numer pakietu. Pakiety nale¿y instalowaæ wg poprawnej kolejno¶ci.";
$lang->upgrade_legend_title="Legenda";
$lang->upgrade_legend=array(
                '0'=>"Plik poprawny",
                '1'=>"Plik zmodyfikowany",
                '2'=>"Plik na dysku jest nowszy ni¿ plik z aktualizacji",
                '3'=>"Plik zmodyfikowany, indywidualna modyfikacja",
                '4'=>"Plik zmodyfikowany. Zatwierdzony w poprzedniej aktualizacji",
                'repair'=>"Edycja modyfikacji pliku. <b>Opcja tylko dla zaawansowanych programistów PHP !!!</b>",
                );
$lang->upgrade_update="Zainstaluj uaktualnienie";
$lang->upgrade_update_not_allowed="System wykry³ konflikty w plikach. Nie mo¿na zainstalowaæ uaktualnienia.";
$lang->upgrade_hard_install="Ignoruj konflikty. Zainstaluj pliki z pakietu aktualizacyjnego.";
$lang->upgrade_terms="UWAGA! 
1. Instalacja uaktualnienia spowoduje nadpisanie plików, w których wykryto
   modyfikajcê w stosunku do oryginalnej wersji pliku. 
2. Mo¿e to spowodowaæ, ¿e znikn± indywidualnie wprowadzone do pliku zmiany.
   W celu po³±czenia zmian nale¿y po zainstalowaniu pakietu wprowadziæ je 
   jeszcze raz (system wykona kopie plików ze sklepu).
3. Gwarancja NIE OBEJMUJE wprowadzenia indywidualnych zmian do plików
   zainstalowanych z pakietu aktualizacyjnego.
";
$lang->upgrade_file_info="System dokona³ próby automatycznego po³±czenia zmian wprowadzonych w pakiecie aktualizacyjnym oraz zmian indywidualnie
wprowadzonych na danym pliku.
<pre>
UWAGA! 
1. Wykonaj kopiê instalowanego pliku, tak ¿eby mo¿na by³o w ka¿dej chwili przywróciæ oryginaln± wersjê.
2. Instalacja zmian NIE JEST objeta gwarancj±. Je¶li nie jeste¶ pewien po³±czonych zmian NIE INSTALUJ pliku. 
3. Gwarancja NIE OBEJMUJE wprowadzenia indywidualnych zmian do plików
   zainstalowanych z pakietu aktualizacyjnego.
</pre>
  ";
$lang->upgrade_accept="Akceptujê";
$lang->bugs_download_source="Obejrzyj plik, który bêdzie instalowany (z po³±czonymi zmianami)";
$lang->bugs_download_diff_result="Obejrzyj wykryte ró¿nice pomiêdzy plikiem z pakietu a wersj± oryginaln±";
$lang->upgrade_modified="Zmodyfikowany";
$lang->upgrade_repo_not_exists="Nie mo¿na dokonaæ automatycznego po³±czenia zmian. Brak repozytorium wersji. Informacja zosta³a wys³ana do administratora. Spróbuj pó¼niej.";
$lang->upgrade_info_code="Opcjonalny kod";
$lang->upgrade_code_error="B³êdny kod aktywacyjny pakietu.";
$lang->upgrade_error_save_pkg="Nie uda³o siê zapisaæ pakietu w ./admin/upgrade";
$lang->upgrade_img="[IMG]";
?>