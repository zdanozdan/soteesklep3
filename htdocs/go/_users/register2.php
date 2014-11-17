<?php
/**
 * Wprowadz dane korespondencyjne przy rejestracji uzytkownika
 *
 * @author m@sote.pl
 * @version $Id: register2.php,v 2.11 2005/01/20 15:00:24 maroslaw Exp $
* @package    users
 */

// Jesli w sesji zapisany jest obiekt, to klasa tego obiektu, 
// musi byc zaladowana przed otworzeniem sesji!
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}

$global_database=true;
$global_secure_test=true;
include_once ("../../../include/head.inc");

if(empty($head_open)){
    // naglowek
    $theme->head();
    $theme->page_open_head("page_open_1_head");
}

// zapisz w sesji dane z formularza billingowego
$form=&$form_check->form;
if (! empty($form)) {
    $sess->register("form",$form);    
}

// klasa obslugujaca sprawdzanie poprawnosci formularzy HTML
//include_once ("include/form_check.inc");
//$form_check = new FormCheck; 
include_once ("./include/my_form_check.inc.php");
$form_check = new MyFormCheck; 

// odczytaj parametry przekazane z formularza HTML
// ktore sa zapisane w tablicy form
if (! empty($_POST['form_cor'])) {
    $form_cor=$_POST['form_cor'];
    $form_check->form=&$form_cor; // przekaz dane z formularza
}


// definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
// (z klasy FormCheck)
$form_check->fun['firm']="null";
$form_check->fun['name']="string";
$form_check->fun['surname']="string";
$form_check->fun['street']="string";
$form_check->fun['street_n1']="string";
$form_check->fun['street_n2']="null";
$form_check->fun['postcode']="string";
$form_check->fun['city']="string";
$form_check->fun['phone']="string";
$form_check->fun['email']="users_email";


// sprawdz czy jest to wywolanie wyswietlenia formularza, czy sprawdzenie
if (! empty($form_cor['check'])) {
    $form_check->check=my($form_cor['check']);
}

// tablica z komunikatami bledow
$form_check->errors=$lang->register_cor_form_errors;

// sprawdz czy formularz jest poprawnie wyswietlony
// wymagane sa pola, ktore maja odpowiednia wartosc w $form_check->errors
// tj. maja przypisany komunikat o bledzie        
if ($form_check->check=="true") {
    if ($form_check->form_test()) {
        // poprawnie wypeniony formularz      
        $sess->register("form_cor",$form_cor);
        include_once ("register3.php");
        exit;
    }
}  

// wyswietl ponownie formularz, jesli zostal zle
// wypelniony (lub jesli jest to pierwsze wywolanie)
// w przypadku zlego wypelnienia, dodaj komunikaty o bledach
// zawarte (po sprawdzeniu formularza) w tablicy $form_check->errors_found
if (empty($form_cor)) {
    if (! empty($_SESSION['form_cor'])) {
        $form_cor=$_SESSION['form_cor'];
    }
}

if (empty($form_cor)) $form_cor=array();
$theme->action="register2.php";
$theme->register_cor_form($form_cor,$form_check);        


$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
