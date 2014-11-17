<?php
/**
 * Komunikaty o bledach
 */ 

class ErrorAdmin {
    var $error="Bledne wywolanie";
    var $wrong_pin="Bledny PIN";
    var $ftp_connect="Brak odpowiedzi serwera FTP";
    var $db="B³±d bazy danych";
    var $ftp_login="Login lub has³o nie s± poprawne";
    var $ftp_put="Nie uda³o siê wrzucenie pliku przez FTP, sprawd¼ uprawnienia, ¶cie¿kê itp.";
    var $ftp_chdir="Nie udalo sie przejsc do katalogu";
    var $ftp_mkdir="Nie udalo sie zalozyc katalogu";
    var $ftp_rename="Nie udalo sie zmienic nazwy pliku/katalogu";
    //var $ftp_chmod="Nie uda³o siê sprawdziæ i ustawiæ odpowiednich uprawnieñ do za³±czonego pliku";
    var $ftp_delete="Nie uda³o siê usun±c pliku";
    var $db_connect="Nie uda³o siê po³±czenie z baz± danych";
    var $edit_nophoto="Nie za³±czono zdjêcia";
    var $upload_size="Za³±czono za du¿y plik";    
    var $admin_auth_no_ftp_data="Brak odpowiedniego wpisu w bazie";
    var $access_deny="Uzytkwonik nie ma praw dostepu do wywolywanej funkcji";
    var $buttons_form_name="Brak nazwy formularza. Nie mozna wywolac metody javascript submit().";
    var $license_deny="B³êdny numer licencji";
    
    function show($error="",$type="") {
        if (empty($error)) $error=$this->error;
        print "<font color=red>".$this->$error."</font><br>";
        switch ($type) {
        case "die": die();
            break;
        }
    } // end error()
} // end class Error

$error =& new ErrorAdmin;
$debug_test=1;
?>
