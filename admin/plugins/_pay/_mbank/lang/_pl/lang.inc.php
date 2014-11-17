<?php
$lang->mbank_transfer="mTransfer";
$lang->mbank_title="mBank ustawienia/aktywacja";
$lang->mbank_info="Je¶li jeste¶ zainteresowany aktywacj± us³ugi lub masz pytania dotycz±ce p³atno¶ci realizowanych za pomoc± us³ugi mTransfer napisz na adres";
$lang->mbank_info_url="Poni¿ej znajduj± siê linki, ktore nale¿y przes³aæ do PolCardu na adres";
$lang->mbank_email="mtransfer@mbank.pl";
$lang->mbank=array(
                'ServiceID'=>"ServiceID - identyfikator us³ugi nadany przez mBank (8 cyfr)",
                'status'=>"Wy³±cz tryb testowy",
                'active'=>"Wstaw w sklepie system p³atno¶ci przez mTransfer",
                );
$lang->mbank_menu=array(
                'setup'=>"Ustawienia",
                'url'=>"Generuj linki",
                'info'=>"O us³udze",
                'order'=>"Transakcje->mTransfer",
                );
$lang->mbank_url=array(
                'true'=>"Poprawna autoryzacja",
                'false'=>"Brak autoryzacji",
                'error'=>"B³±d podczas autoryzacji",
                );
$lang->mbank_config=array(
                'bar'=>"Konfiguracja systemu mTransfer",
                'frames1'=>"Parametry konta pocztowego",
                'frames2'=>"Parametry po³±czenia",
                'id'=>"Numer partnerski: ",
                'test'=>"Tryb testowy",
                'product'=>"Tryb produkcyjny",
                'mode'=>"Tryb pracy systemu: ",
                'save'=>"Zapisz konfiguracje",
                'email'=>"Adres email partnera: ",
                'pay_method'=>"Metoda p³atno¶ci: ",
                'currency'=>"Waluta p³atno¶ci: ",
                'info'=>"Dodatkowa informacja do zamówienia: ",
                'coding'=>"Zabezpieczenie transakcji",
                'none'=>"Brak",
                'md5'=>"MD5",
                'sha1'=>"SHA1",
                'server'=>"Adres serwera mBank",
                'key'=>"Klucz kodowania",
                'back_ok'=>"Adres powrotny dla poprawnej autoryzacji",
                'back_error'=>"Adres powrotny dla b³êdnej autoryzacji",
                'pass_gpg'=>"Has³o do klucza prywatnego: ",
                'login'=>"Login do konta email: ",
                'password'=>"Has³o do konta email: ",
                'mail_host'=>"Nazwa serwera pocztowego: ",
                'title_email'=>"Tytu³ maila z transakcjami",
                'no_safe'=>"Adres dodatkowego serwera",
                );
$lang->mbank_send_info="Mo¿esz tak¿e klikn±æ poni¿szy link. System automatycznie wy¶le maila do PolCardu z w/w konfiguracj±.";
$lang->mbank_send_info_submit="Wy¶lij automatycznego maila do PolCardu";
$lang->merchant_license_nr="Licencja nr";
$lang->merchant_license_who="Firma";
$lang->merchant_update="Aktualizuj dane";
$lang->mbank_info_info="<B>Podstawowe informacje</b><BR><BR>mTRANSFER to sposób na ³atw± realizacjê p³atno¶ci przez Internet - za pomoc± przelewu z rachunku w mBanku. Przelew realizowany jest jako przelew dowolny (z rachunku eKONTO, mBIZNES Konto lub izzyKONTO).
Je¶li posiadasz mBIZNES Konto mo¿esz korzystaæ z us³ugi mTRANSFER tak¿e w odwrotn± stronê. Po zarejestrowaniu na Twój rachunek w mBanku kontrahenci, którzy posiadaj± konto w mBanku bêd± mogli wp³acaæ pieni±dze w prosty sposób - na dodatek on-line.
Zobacz, jak mTRANSFER mo¿esz wykorzystaæ w swoim biznesie
mTRANSFER u³atwia zlecanie przelewów dowolnych - nie musisz wpisywaæ danych odbiorcy i numeru jego rachunku bankowego. Najczê¶ciej równie¿ kwota i data realizacji przelewu s± ju¿ wype³nione przez sprzedawcê. Jednocze¶nie przelew mTRANSFER jest równie bezpieczny jak inne przelewy dowolne w mBanku - potwierdzasz go has³em jednorazowym z aktywnej listy hase³.
Zrealizowany przelew mTRANSFER widoczny jest jako operacja wykonana w historii rachunku, natomiast przelew zlecony z dat± przysz³± jest widoczny jako operacja planowana i mo¿e byæ odwo³any.
Uwaga! Aby realizowaæ transakcje za pomoc± mTRANSFER potrzebujesz aktywnej listy hase³ jednorazowych.";
$lang->mbank_more_info="Wiêcej informacji na stronie";
$lang->mbank_subject="Informacja z konfiguracja sklepu - adresy URL do systemu IOO";
$lang->mbank_message="Konfiguracja sklepu internetowego {WWW}
POSID: {POSID}

Ponizej znajduja sie adresy URL dotyczace konfiguracji IOO:
{URLS}

{MERCHANT}

--
UWAGA! Wiadomosc wygenerowana automatycznie z aplikacji SOTEeSKLEP.
";
$lang->mbank_send_ok="Konfiguracja sklepu zosta³a wys³ana do PolCardu. Je¶li us³uga zostanie aktywowana zostaniesz poinformowany(a) mailem lub tel. W razie pytañ prosze kontaktowaæ siê z PolCardem pod adresem e-mail: ";
$lang->mbank_send_error="Niestety nieuda³o siê wys³aæ maila z konfiguracj± sklepu do PolCradu. Wy¶lij maila ze swojego programu pocztowego z danymi podanymi w \"Ustawieniach\".";
$lang->mbank_empty_posid="Konfiguracja nie mo¿e byæ wys³ana. Wprowadz w \"Ustawieniach\" numer POSID nadany przez PolCard dla Twojego sklepu";
?>