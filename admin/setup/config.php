<?php
/**
 * Formularz + walidacja danych dostêpu do bazy, ftp, licencji, pinu
 *
 * @author m@sote.pl
 * @version $Id: config.php,v 2.5 2005/01/20 15:00:12 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    setup
 */

$global_database=false; // wylaczenie podwojnego sprawdzania autoryzacji
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head.inc");

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");


// klasa obslugujaca sprawdzanie poprawnosci formularzy HTML
include_once ("./include/my_form_check.inc.php");
$form_check = new MyFormCheck; 

// odczytaj parametry przekazane z formularza HTML
// ktore sa zapisane w tablicy form
if (! empty($_POST['form'])) {
    $form=$_POST['form'];
    $form_check->form=&$form; // przekaz dane z formularza 
} else {
    // domyslne wartosci formularza
    $form['dbhost']='localhost';
    $form['dbname']='soteesklep2';
    $form['ftp_host']='localhost';      
}

// definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
// (z klasy FormCheck)
$form_check->fun['dbhost']="string";
$form_check->fun['dbname']="string";
$form_check->fun['admin_dbuser']="string";
$form_check->fun['admin_dbpassword']="string";
$form_check->fun['nobody_dbuser']="string";
$form_check->fun['nobody_dbpassword']="string";
$form_check->fun['ftp_host']="ftp_host";
$form_check->fun['ftp_user']="ftp_user";
$form_check->fun['ftp_password']="ftp_test";
$form_check->fun['ftp_dir']="string";

// sprawdz czy jest to wywolanie wyswietlenia formularza, czy sprawdzenie
if (! empty($form['check'])) {
    $form_check->check=my($form['check']);
}

// tablica z komunikatami bledow
$form_check->errors=$lang->setup_dbftp_errors;

// sprawdz czy formularz jest poprawnie wyswietlony
// wymagane sa pola, ktore maja odpowiednia wartosc w $form_check->errors
// tj. maja przypisany komunikat o bledzie        
if ($form_check->check=="true") {
    if ($form_check->form_test()) {
        // poprawnie wypeniony formularz                
        include_once ("setup.php");
        exit;
    }
}  

$theme->form_check=&$form_check;
$theme->form=&$form;
include_once ("./html/setup.html.php");


include_once ("themes/base/base_theme/foot_setup.html.php");

// stopka
include_once ("include/foot.inc");
?>
