<?php
$lang->upgrade_updates="Instaluj uaktualnienia";
$lang->upgrade_check_new="Sprawd� dost�pne aktualizacje";
$lang->upgrade_title="Automatyczna aktualizacja programu";
$lang->upgrade_get_info="Za��cz aktualizacj� sklepu";
$lang->upgrade_file_uploaded="Plik aktualizacji pakietu zosta� za��czony: ";
$lang->upgrade_files="Lista zaktualizowanych plik�w";
$lang->upgrade_done="Aktualizacja zako�czona";
$lang->upgrade_prev="Aktualizacje zainstalowane w sklepie";
$lang->upgrade_25_menu=array(
                'order'=>"Aktualizuj dane transakcji z wersji 2.5->3.0",
                'users'=>"Aktualizuj dane klient�w z wersji 2.5->3.0",
                'themes'=>"Aktualizuj temat wersji 2.5->3.0",
                );
$lang->upgrade_25_done="Dane zosta�y zaktualizowane";
$lang->upgrade_25_error="Dane nie zosta�y zaktualizowane";
$lang->upgrade_25_description="Aktualizcja wersji 2.5->3.0";
$lang->upgrade_name_theme="Nazwa tematu do aktualizacji";
$lang->upgrade_file_status=array(
                '2'=>"Pomini�ty. Wersja na dysku jest nowsza od wersji z aktualizacji.",
                '1'=>"Plik nie zosta� zaktualizowany. Wykryto modyfikacj�.",
                '3'=>"Pomini�ty. Plik z indywidualn� modyfikacj�.",
                '4'=>"Zatwierdzony w poprzedniej aktualizacji.",
                );
$lang->upgrade_file_status_simulation=array(
                '2'=>"Test: Zostanie Pomini�ty. Wersja na dysku jest nowsza od wersji z aktualizacji.",
                '1'=>"Test: Wykryto modyfikacj�.",
                '3'=>"Test: Plik z indywidualn� modyfikacj�.",
                '4'=>"Test: Zatwierdzony w poprzedniej aktualizacji.",
                );
$lang->upgrade_checksums_upgraded="Baza sum kontrolnych programu zosta�a zaktualizowana.";
$lang->upgrade_checksums_upgrade_error="Nie uda�o si� zaktualizowa� bazy sum kontrolnych.";
$lang->upgrade_pkg=array(
                '1.01'=>"Wprowad� do sklepu aktualizacj� oznaczon� numerem 30003. Jest to aktualizacja wymagana do instalowania kolejnych ulepsze� w sklepie.",
                );
$lang->upgrade_nomd5_info="Brak bazy sum kontrolnych programu.";
$lang->upgrade_md5_install="Pobierz baz�";
$lang->upgrade_md5_installed="Baza sum kontrolnych zainstalowana.";
$lang->upgrade_md5_continue="Przejd� do systemu aktualizacji";
$lang->upgrade_to_install="Pakiety aktualizyjne dost�pne do zainstalowania (pakiety dost�pne na stronie <a href=http://serwis.sote.pl>http://serwis.sote.pl</a>)";
$lang->upgrade_check_new_version_title="Sprawdzenie dost�pnych aktualizacji";
$lang->upgrade_new_not_found="Aktualnie w sklepie zainstalowane s� wszystkie dost�pne, dla wersji {VERSION}, aktualizacje.<br /> Nie ma nowych aktualizacji.";
$lang->upgrade_database_updated="Baza danych zosta�a zaktualizowana.";
$lang->upgrade_diff_title="Automatyczne ��czenie zmian w pliku ze zmianami z pakietu aktualizacyjnego";
$lang->upgrade_file_repair="Analizuj/Po��cz zmiany";
$lang->upgrade_file_not_found="Brak danych plik�w";
$lang->upgrade_file=array(
                'path'=>"Wersja pliku na dysku",
                'upgrade'=>"Wersja pliku w pakiecie aktualizacyjnym",
                'diff'=>"<b>Plik z dysku z naniesionymi modyfikacjami z pakietu aktualizacyjnego</b>",
                );
$lang->upgrade_diff_file_upgraded="Plik zosta� zapami�tany i zostanie zainstalowany w obecnej sesji razem z instalacj� pakietu.<br />Uwaga! Po wylogowaniu si�, nale�y powt�rzy� operacj� ��czenia zmian.";
$lang->upgrade_diff_patch="Wykryte r�nice/podgl�d";
$lang->upgrade_unknown_gid="Brak numeru GID. Pliki graficzne nie zosta�y zaktualizowane.";
$lang->upgrade_individual_mod="indywidualna modyfikacja";
$lang->upgrade_files_list="Lista plik�w znajduj�cych si� w pakiecie aktualizacyjnym";
$lang->upgrade_files_simulation="Wynik probnej instalacji pakietu aktualizacyjnego. Weryfikacja sum kontrolnych.";
$lang->upgrade_error_ext="Nieprawid�owy format pakietu aktualizacyjnego.";
$lang->upgrade_wrong_format="Error: Brak numeru wersji pakietu. B��dny format uaktualnienia.";
$lang->upgrade_already_installed="Pakiet jest ju� zainstalowany";
$lang->upgrade_devel_config="DEVEL: Konfiguracja";
$lang->upgrade_wrong_pkg_number="B��dny numer pakietu. Pakiety nale�y instalowa� wg poprawnej kolejno�ci.";
$lang->upgrade_legend_title="Legenda";
$lang->upgrade_legend=array(
                '0'=>"Plik poprawny",
                '1'=>"Plik zmodyfikowany",
                '2'=>"Plik na dysku jest nowszy ni� plik z aktualizacji",
                '3'=>"Plik zmodyfikowany, indywidualna modyfikacja",
                '4'=>"Plik zmodyfikowany. Zatwierdzony w poprzedniej aktualizacji",
                'repair'=>"Edycja modyfikacji pliku. <b>Opcja tylko dla zaawansowanych programist�w PHP !!!</b>",
                );
$lang->upgrade_update="Zainstaluj uaktualnienie";
$lang->upgrade_update_not_allowed="System wykry� konflikty w plikach. Nie mo�na zainstalowa� uaktualnienia.";
$lang->upgrade_hard_install="Ignoruj konflikty. Zainstaluj pliki z pakietu aktualizacyjnego.";
$lang->upgrade_terms="UWAGA! 
1. Instalacja uaktualnienia spowoduje nadpisanie plik�w, w kt�rych wykryto
   modyfikajc� w stosunku do oryginalnej wersji pliku. 
2. Mo�e to spowodowa�, �e znikn� indywidualnie wprowadzone do pliku zmiany.
   W celu po��czenia zmian nale�y po zainstalowaniu pakietu wprowadzi� je 
   jeszcze raz (system wykona kopie plik�w ze sklepu).
3. Gwarancja NIE OBEJMUJE wprowadzenia indywidualnych zmian do plik�w
   zainstalowanych z pakietu aktualizacyjnego.
";
$lang->upgrade_file_info="System dokona� pr�by automatycznego po��czenia zmian wprowadzonych w pakiecie aktualizacyjnym oraz zmian indywidualnie
wprowadzonych na danym pliku.
<pre>
UWAGA! 
1. Wykonaj kopi� instalowanego pliku, tak �eby mo�na by�o w ka�dej chwili przywr�ci� oryginaln� wersj�.
2. Instalacja zmian NIE JEST objeta gwarancj�. Je�li nie jeste� pewien po��czonych zmian NIE INSTALUJ pliku. 
3. Gwarancja NIE OBEJMUJE wprowadzenia indywidualnych zmian do plik�w
   zainstalowanych z pakietu aktualizacyjnego.
</pre>
  ";
$lang->upgrade_accept="Akceptuj�";
$lang->bugs_download_source="Obejrzyj plik, kt�ry b�dzie instalowany (z po��czonymi zmianami)";
$lang->bugs_download_diff_result="Obejrzyj wykryte r�nice pomi�dzy plikiem z pakietu a wersj� oryginaln�";
$lang->upgrade_modified="Zmodyfikowany";
$lang->upgrade_repo_not_exists="Nie mo�na dokona� automatycznego po��czenia zmian. Brak repozytorium wersji. Informacja zosta�a wys�ana do administratora. Spr�buj p�niej.";
$lang->upgrade_info_code="Opcjonalny kod";
$lang->upgrade_code_error="B��dny kod aktywacyjny pakietu.";
$lang->upgrade_error_save_pkg="Nie uda�o si� zapisa� pakietu w ./admin/upgrade";
$lang->upgrade_img="[IMG]";
?>