<?php
$lang->setup_title="Instalacja SOTEeSKLEP";
$lang->setup_start_info="Witamy w programie instalacyjnym programu do obs³ugi sklepu internetowego

SOTEeSKLEP.

";
$lang->setup_choose_lang="Wybierz jêzyk/Choose language";
$lang->setup_next="Dalej/Next";
$lang->setup_license_accept="Akceptujê warunki licencji";
$lang->setup_system_php="Sprawdzenie opcji PHP";
$lang->setup_system_type_title="Wybierz rodzaj instalacji";
$lang->setup_system_type=array(
                'full'=>"zaawansowana",
                'simple'=>"podstawowa",
                'demo'=>"demo",
                'rebuild'=>"reinstalacja",
                'upgrade'=>"aktualizacja wersji (na istniej±cej bazie danych)",
                'join'=>"instalacja w trybie multi-shop",
                );
$lang->setup_system_os_title="Wybierz System operacyjny";
$lang->setup_system_os=array(
                'linux'=>"Linux",
                'freebsd'=>"FreeBSD",
                'windows'=>"Windows",
                'macosx'=>"Mac OS X",
                );
$lang->setup_system_host_title="Wybierz miejsce instalacji";
$lang->setup_system_host=array(
                'local'=>"lokalnie",
                'internet'=>"w internecie u providera",
                'home.pl'=>"na serwerze <b><font color=black>hom</font><font color=red>e</font><font color=black>.pl</font></b>",
                );
$lang->setup_system_plugins_title="Dodaj do instalacji modu³y/wtyczki";
$lang->setup_system_plugins=array(
                'newsedit'=>"Edycja nowo¶ci, HTML",
                'hidden_price'=>"Nie pokazuj ceny",
                'in_category'=>"inne produkty z tej samej kategorii",
                'polcard'=>"p³atno¶æ kart± - PolCard",
                'ecard'=>"p³atno¶æ kart± - eCard",
                'mbank'=>"p³atno¶ci przez mBank",
                );
$lang->setup_plugins_code="Podaj kod do instalacji modu³ów";
$lang->setup_steps=array(
                '0'=>"Start",
                '1'=>"Dane MySQL,FTP",
                '2'=>"Katalog FTP",
                '3'=>"Zakoñczenie instalacji",
                );
$lang->setup_form_mysql=array(
                'title'=>"Dane dostêpu do bazy danych MySQL",
                'dbhost'=>"serwer bazy danych",
                'dbname'=>"nazwa bazy",
                'dbuser'=>"u¿ytkownik bazy",
                'dbpass'=>"has³o dostêpu do bazy",
                );
$lang->setup_form_ftp=array(
                'title'=>"Dane dostêpu do konta FTP",
                'ftp_host'=>"serwer FTP",
                'ftp_user'=>"u¿ytkownik ftp",
                'ftp_password'=>"has³o",
                );
$lang->setup_simple_title="Instalacja uproszczona";
$lang->setup_simple_errors=array(
                'dbhost'=>"Brak wpisu",
                'dbname'=>"Brak wpisu",
                'admin_dbuser'=>"Brak wpisu",
                'admin_dbpassword'=>"Sprawd¼ dane, nie uda³o siê po³±czyæ z serwerem bazy danych.",
                'ftp_host'=>"Brak wpisu",
                'ftp_user'=>"Brak wpisu",
                'ftp_password'=>"Sprawd¼ dane, nie uda³o siê po³±czyæ z serwerem FTP.",
                'pin'=>"Brak PIN",
                'pin2'=>"B³êdnie powtórzony PIN",
                'license'=>"Nieprawid³owy numer licencji",
                'license_who'=>"Brak wpisu",
                );
$lang->setup_ftp_dir="Wybierz katalog FTP zawieraj±cy sklep";
$lang->setup_ftp_select="Wybierz katalog";
$lang->setup_ftp_dir2="inny";
$lang->setup_ftp_dir2_not_found="wska¿ katalog FTP";
$lang->setup_ftp_dir_error="B³êdny katalog FTP. Wskazany katalog nie zawiera sklepu";
$lang->setup_pin_title="Podaj dane dotycz±ce kodowania danych i licencji programu";
$lang->setup_pin="Wprowadz dowolny PIN";
$lang->setup_pin2="Powtórz PIN";
$lang->setup_pin_info="Zapamiêtaj swój PIN !";
$lang->setup_license_nr="Nr licencji";
$lang->setup_license_who="Firma/Osoba";
$lang->setup_create_db="Tworzenie struktury bazy danych";
$lang->setup_create_table="Tworzê tabele";
$lang->setup_create_table_ok="OK";
$lang->setup_create_table_error="Tabela istnieje";
$lang->setup_ftp_save="Kodowanie danych";
$lang->setup_crypt=array(
                'ftp'=>"Kodowanie danych FTP",
                'mysql'=>"Kodowanie danych dostêpu do bazy danych",
                'license'=>"Kodowanie danych licencji",
                'pin'=>"Kodowanie numeru PIN",
                'keys'=>"Generowanie i kodowanie kluczy szyfrowania",
                'multi_shop'=>"Ustawienia multi-shop",
                );
$lang->setup_install_complete="<B>Gratulacje!</B> <P> Sklep zosta³ zainstalowany";
$lang->setup_ftp_change="Wprowad¼ nowe has³o FTP";
$lang->setup_ftp_changed="Has³o FTP zosta³o zaktualizowane";
$lang->setup_license="Licencja";
$lang->setup_errors=array(
                'no_frame'=>"Twoja przegl±darka nie obs³uguje ramek. Skorzystaj np. z Netscape7 lub Internet Explorer 5(6).",
                );
?>