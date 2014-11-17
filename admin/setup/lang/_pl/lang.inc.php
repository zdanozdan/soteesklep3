<?php
$lang->setup_title="Instalacja SOTEeSKLEP";
$lang->setup_start_info="Witamy w programie instalacyjnym programu do obs�ugi sklepu internetowego

SOTEeSKLEP.

";
$lang->setup_choose_lang="Wybierz j�zyk/Choose language";
$lang->setup_next="Dalej/Next";
$lang->setup_license_accept="Akceptuj� warunki licencji";
$lang->setup_system_php="Sprawdzenie opcji PHP";
$lang->setup_system_type_title="Wybierz rodzaj instalacji";
$lang->setup_system_type=array(
                'full'=>"zaawansowana",
                'simple'=>"podstawowa",
                'demo'=>"demo",
                'rebuild'=>"reinstalacja",
                'upgrade'=>"aktualizacja wersji (na istniej�cej bazie danych)",
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
$lang->setup_system_plugins_title="Dodaj do instalacji modu�y/wtyczki";
$lang->setup_system_plugins=array(
                'newsedit'=>"Edycja nowo�ci, HTML",
                'hidden_price'=>"Nie pokazuj ceny",
                'in_category'=>"inne produkty z tej samej kategorii",
                'polcard'=>"p�atno�� kart� - PolCard",
                'ecard'=>"p�atno�� kart� - eCard",
                'mbank'=>"p�atno�ci przez mBank",
                );
$lang->setup_plugins_code="Podaj kod do instalacji modu��w";
$lang->setup_steps=array(
                '0'=>"Start",
                '1'=>"Dane MySQL,FTP",
                '2'=>"Katalog FTP",
                '3'=>"Zako�czenie instalacji",
                );
$lang->setup_form_mysql=array(
                'title'=>"Dane dost�pu do bazy danych MySQL",
                'dbhost'=>"serwer bazy danych",
                'dbname'=>"nazwa bazy",
                'dbuser'=>"u�ytkownik bazy",
                'dbpass'=>"has�o dost�pu do bazy",
                );
$lang->setup_form_ftp=array(
                'title'=>"Dane dost�pu do konta FTP",
                'ftp_host'=>"serwer FTP",
                'ftp_user'=>"u�ytkownik ftp",
                'ftp_password'=>"has�o",
                );
$lang->setup_simple_title="Instalacja uproszczona";
$lang->setup_simple_errors=array(
                'dbhost'=>"Brak wpisu",
                'dbname'=>"Brak wpisu",
                'admin_dbuser'=>"Brak wpisu",
                'admin_dbpassword'=>"Sprawd� dane, nie uda�o si� po��czy� z serwerem bazy danych.",
                'ftp_host'=>"Brak wpisu",
                'ftp_user'=>"Brak wpisu",
                'ftp_password'=>"Sprawd� dane, nie uda�o si� po��czy� z serwerem FTP.",
                'pin'=>"Brak PIN",
                'pin2'=>"B��dnie powt�rzony PIN",
                'license'=>"Nieprawid�owy numer licencji",
                'license_who'=>"Brak wpisu",
                );
$lang->setup_ftp_dir="Wybierz katalog FTP zawieraj�cy sklep";
$lang->setup_ftp_select="Wybierz katalog";
$lang->setup_ftp_dir2="inny";
$lang->setup_ftp_dir2_not_found="wska� katalog FTP";
$lang->setup_ftp_dir_error="B��dny katalog FTP. Wskazany katalog nie zawiera sklepu";
$lang->setup_pin_title="Podaj dane dotycz�ce kodowania danych i licencji programu";
$lang->setup_pin="Wprowadz dowolny PIN";
$lang->setup_pin2="Powt�rz PIN";
$lang->setup_pin_info="Zapami�taj sw�j PIN !";
$lang->setup_license_nr="Nr licencji";
$lang->setup_license_who="Firma/Osoba";
$lang->setup_create_db="Tworzenie struktury bazy danych";
$lang->setup_create_table="Tworz� tabele";
$lang->setup_create_table_ok="OK";
$lang->setup_create_table_error="Tabela istnieje";
$lang->setup_ftp_save="Kodowanie danych";
$lang->setup_crypt=array(
                'ftp'=>"Kodowanie danych FTP",
                'mysql'=>"Kodowanie danych dost�pu do bazy danych",
                'license'=>"Kodowanie danych licencji",
                'pin'=>"Kodowanie numeru PIN",
                'keys'=>"Generowanie i kodowanie kluczy szyfrowania",
                'multi_shop'=>"Ustawienia multi-shop",
                );
$lang->setup_install_complete="<B>Gratulacje!</B> <P> Sklep zosta� zainstalowany";
$lang->setup_ftp_change="Wprowad� nowe has�o FTP";
$lang->setup_ftp_changed="Has�o FTP zosta�o zaktualizowane";
$lang->setup_license="Licencja";
$lang->setup_errors=array(
                'no_frame'=>"Twoja przegl�darka nie obs�uguje ramek. Skorzystaj np. z Netscape7 lub Internet Explorer 5(6).",
                );
?>