<?php
$lang->mbank_transfer="mTransfer";
$lang->mbank_title="mBank ustawienia/aktywacja";
$lang->mbank_info="Je�li jeste� zainteresowany aktywacj� us�ugi lub masz pytania dotycz�ce p�atno�ci realizowanych za pomoc� us�ugi mTransfer napisz na adres";
$lang->mbank_info_url="Poni�ej znajduj� si� linki, ktore nale�y przes�a� do PolCardu na adres";
$lang->mbank_email="mtransfer@mbank.pl";
$lang->mbank=array(
                'ServiceID'=>"ServiceID - identyfikator us�ugi nadany przez mBank (8 cyfr)",
                'status'=>"Wy��cz tryb testowy",
                'active'=>"Wstaw w sklepie system p�atno�ci przez mTransfer",
                );
$lang->mbank_menu=array(
                'setup'=>"Ustawienia",
                'url'=>"Generuj linki",
                'info'=>"O us�udze",
                'order'=>"Transakcje->mTransfer",
                );
$lang->mbank_url=array(
                'true'=>"Poprawna autoryzacja",
                'false'=>"Brak autoryzacji",
                'error'=>"B��d podczas autoryzacji",
                );
$lang->mbank_config=array(
                'bar'=>"Konfiguracja systemu mTransfer",
                'frames1'=>"Parametry konta pocztowego",
                'frames2'=>"Parametry po��czenia",
                'id'=>"Numer partnerski: ",
                'test'=>"Tryb testowy",
                'product'=>"Tryb produkcyjny",
                'mode'=>"Tryb pracy systemu: ",
                'save'=>"Zapisz konfiguracje",
                'email'=>"Adres email partnera: ",
                'pay_method'=>"Metoda p�atno�ci: ",
                'currency'=>"Waluta p�atno�ci: ",
                'info'=>"Dodatkowa informacja do zam�wienia: ",
                'coding'=>"Zabezpieczenie transakcji",
                'none'=>"Brak",
                'md5'=>"MD5",
                'sha1'=>"SHA1",
                'server'=>"Adres serwera mBank",
                'key'=>"Klucz kodowania",
                'back_ok'=>"Adres powrotny dla poprawnej autoryzacji",
                'back_error'=>"Adres powrotny dla b��dnej autoryzacji",
                'pass_gpg'=>"Has�o do klucza prywatnego: ",
                'login'=>"Login do konta email: ",
                'password'=>"Has�o do konta email: ",
                'mail_host'=>"Nazwa serwera pocztowego: ",
                'title_email'=>"Tytu� maila z transakcjami",
                'no_safe'=>"Adres dodatkowego serwera",
                );
$lang->mbank_send_info="Mo�esz tak�e klikn�� poni�szy link. System automatycznie wy�le maila do PolCardu z w/w konfiguracj�.";
$lang->mbank_send_info_submit="Wy�lij automatycznego maila do PolCardu";
$lang->merchant_license_nr="Licencja nr";
$lang->merchant_license_who="Firma";
$lang->merchant_update="Aktualizuj dane";
$lang->mbank_info_info="<B>Podstawowe informacje</b><BR><BR>mTRANSFER to spos�b na �atw� realizacj� p�atno�ci przez Internet - za pomoc� przelewu z rachunku w mBanku. Przelew realizowany jest jako przelew dowolny (z rachunku eKONTO, mBIZNES Konto lub izzyKONTO).
Je�li posiadasz mBIZNES Konto mo�esz korzysta� z us�ugi mTRANSFER tak�e w odwrotn� stron�. Po zarejestrowaniu na Tw�j rachunek w mBanku kontrahenci, kt�rzy posiadaj� konto w mBanku b�d� mogli wp�aca� pieni�dze w prosty spos�b - na dodatek on-line.
Zobacz, jak mTRANSFER mo�esz wykorzysta� w swoim biznesie
mTRANSFER u�atwia zlecanie przelew�w dowolnych - nie musisz wpisywa� danych odbiorcy i numeru jego rachunku bankowego. Najcz�ciej r�wnie� kwota i data realizacji przelewu s� ju� wype�nione przez sprzedawc�. Jednocze�nie przelew mTRANSFER jest r�wnie bezpieczny jak inne przelewy dowolne w mBanku - potwierdzasz go has�em jednorazowym z aktywnej listy hase�.
Zrealizowany przelew mTRANSFER widoczny jest jako operacja wykonana w historii rachunku, natomiast przelew zlecony z dat� przysz�� jest widoczny jako operacja planowana i mo�e by� odwo�any.
Uwaga! Aby realizowa� transakcje za pomoc� mTRANSFER potrzebujesz aktywnej listy hase� jednorazowych.";
$lang->mbank_more_info="Wi�cej informacji na stronie";
$lang->mbank_subject="Informacja z konfiguracja sklepu - adresy URL do systemu IOO";
$lang->mbank_message="Konfiguracja sklepu internetowego {WWW}
POSID: {POSID}

Ponizej znajduja sie adresy URL dotyczace konfiguracji IOO:
{URLS}

{MERCHANT}

--
UWAGA! Wiadomosc wygenerowana automatycznie z aplikacji SOTEeSKLEP.
";
$lang->mbank_send_ok="Konfiguracja sklepu zosta�a wys�ana do PolCardu. Je�li us�uga zostanie aktywowana zostaniesz poinformowany(a) mailem lub tel. W razie pyta� prosze kontaktowa� si� z PolCardem pod adresem e-mail: ";
$lang->mbank_send_error="Niestety nieuda�o si� wys�a� maila z konfiguracj� sklepu do PolCradu. Wy�lij maila ze swojego programu pocztowego z danymi podanymi w \"Ustawieniach\".";
$lang->mbank_empty_posid="Konfiguracja nie mo�e by� wys�ana. Wprowadz w \"Ustawieniach\" numer POSID nadany przez PolCard dla Twojego sklepu";
?>