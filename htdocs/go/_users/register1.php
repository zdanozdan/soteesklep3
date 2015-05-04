<?php
/**
 * Formularz rejestracji uzytkownika, dane billingowe                   |
 *
 * @require bool $global_lock_user=true konieczne wczesniejsze wywolanie strony logowania
 * \@session array $form dane z formularza billingowego
 * \@global string $global_register_user_form 
 *
 * @author m@sote.pl
 * @version $Id: register1.php,v 1.2 2007/12/01 10:47:57 tomasz Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true;
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
}
include_once ("../../../include/head.inc");
// nie pokazuj okna logowania przy danych billingowych, przy rejestracji nowego usera
$global_register_user_form="false";

if(empty($head_open)){
    // naglowek
  //$theme->head();
    $theme->page_open_head("page_open_1_head");
}


// klasa obslugujaca sprawdzanie poprawnosci formularzy HTML
include_once ("./include/my_form_check.inc.php");
$form_check = new MyFormCheck; 

// sprawdz czy wywolano wczesniej strone logowania
if (empty($_SESSION['global_lock_user'])) {
   //$theme->go2main();
}

// odczytaj parametry przekazane z formularza HTML
// ktore sa zapisane w tablicy form
if (! empty($_POST['form'])) {
    $form=$_POST['form'];
    $form_check->form=&$form; // przekaz dane z formularza
}

// sprawdz czy jest to wywolanie wyswietlenia formularza, czy sprawdzenie
if (! empty($form['check'])) {
    $form_check->check=my($form['check']);
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
$form_check->fun['nip']="nip";
$form_check->fun['description']="null";
$form_check->fun['cor_addr']="null";
$form_check->fun['country']="null";
// tablica z komunikatami bledow
$form_check->errors=$lang->register_billing_form_errors;

// sprawdz czy formularz jest poprawnie wyswietlony
// wymagane sa pola, ktore maja odpowiednia wartosc w $form_check->errors
// tj. maja przypisany komunikat o bledzie
if ($form_check->check=="true") {
    if ($form_check->form_test()) {
        // poprawnie wypeniony formularz
        $sess->register("form",$form);                        
        include_once ("register3.php");
        exit;
    }
}


// wypelniony (lub jesli jest to pierwsze wywolanie)
// w przypadku zlego wypelnienia, dodaj komunikaty o bledach
// zawarte (po sprawdzeniu formularza) w tablicy $form_check->errors_found
if (! empty($_SESSION['form'])) {
    $form=$_SESSION['form'];    
}

$theme->action="register1.php";

// dolacz menu dla panelu uzytkownika, ale nie wyswietlaj menu jesli uzytkownik nie wpisal jeszcze swoich danych
if (@$_SESSION['global_lock_register']==true) include_once("./include/menu.inc.php"); 
$theme->register_billing_form_users($form,$form_check);        
$theme->theme_file("products4u.html.php");

$theme->page_open_foot("page_open_1_foot");

// zapamietaj wywolanie tej strony
$global_lock_user1=true;
$sess->register("global_lock_user1",$global_lock_user1);

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
