<?php
/**
 * Logowanie, rejestracja uzytkownika                                   |
 *
 * \@session array $form dane z formularza billingowego
 * \@session array $form_cor
 * \@session string $global_login
 * \@session string $global_prv_key
 * \@session bool $global_lock_basket
 * \@session bool $global_lock_register
 * \@session bool $new_login nazwa nowego rejestrowanego uzytkownika
 *
 * @author m@sote.pl
 * @version $Id: new.php,v 2.11 2006/01/16 13:37:28 lechu Exp $
* @package    users
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_SESSION['global_id_user'])) {
    include_once ("./index.php");
    exit;
}


// klasa obslugujaca sprawdzanie poprawnosci formularzy HTML
include_once ("include/form_check.inc");
include_once ("./include/my_form_check.inc.php"); // dodanie indywidualnych funkcji sprawdzania pol formularza
$form_check = new MyFormCheck; 

// odczytaj parametry przekazane z formularza HTML
// ktore sa zapisane w tablicy form
if (! empty($_POST['form'])) {
    $form=$_POST['form'];
    $form_check->form=&$form; // przekaz dane z formularza
}

// sprawdz czy jest to wywolanie wyswietlenia formularza, czy sprawdzenie
if (! empty($form['check_login'])) {
    $form_check->check=my($form['check_login']);
}

// odczytaj, ktory z formularzy zostal wywolany, logowanie czy nowy user
if (! empty($_POST['type'])) {
    $type=$_POST['type'];
} else $type="";

if ($type=="login") {
    // logowanie
    
	// naglowek
	$theme->head();
	$theme->page_open_head("page_open_1_head");
	
    require_once("./include/login.inc.php");
    $login = new LoginUsers;
    if ($login->login($form['login'],$form['password'])) {
        $global_login=$form['login']; // nazwa zalogowanego uzytkownika

        // poprawne logowanie :)
        $form=&$login->form;
        $form_cor=&$login->form_cor;                   
        $global_prv_key=&$login->prv_key;

        $sess->register("form",$form);
        $sess->register("form_cor",$form_cor);
        $sess->register("global_prv_key",$global_prv_key);                    
        $sess->register("global_login",$global_login);
           
        $theme->theme_file("users_login_ok.html.php");                      
    } else {
        // bledne logowanie :(
        $theme->theme_file("users_login_error.html.php");
    } 

    // zapamietaj wywolanie tej strony
    $global_lock_user=true;
    $sess->register("global_lock_user",$global_lock_user);
    
    // stopka
    $theme->foot();
    include_once ("include/foot.inc");
    exit;

} elseif ($type=="new_user") {

    // wyloguj uzytkownika
    require_once("./include/logout.inc.php");
    $logout->logout_user();   
      
    $form_check->fun['login']="login";
    $form_check->fun['password']="password";
    $form_check->fun['password2']="confirm_password";
    $form_check->errors=$lang->users_new_form_errors;
    if ($form_check->check=="true") {
        if ($form_check->form_test()) {
            // poprawnie wypeniony formularz
            include_once("./include/insert_user.inc.php");            
            $new_login=$form['login'];
            $sess->register("global_login",$new_login);
            $sess->register("new_login",$new_login);
            global $config;
            $global_prv_key=md5($config->salt);
	        $sess->register("global_prv_key",$global_prv_key);        
			// naglowek
			$theme->head();
			$theme->page_open_head("page_open_1_head");
            include_once("register1.php");
            exit;
        }
        else {
			$theme->head();
    		$theme->page_open_head("page_open_1_head");
        }
    } else {
		// naglowek
		$theme->head();
		$theme->page_open_head("page_open_1_head");
    }
} else {
	// naglowek
	$theme->head();
	$theme->page_open_head("page_open_1_head");
} 

// wypelniony (lub jesli jest to pierwsze wywolanie)
// w przypadku zlego wypelnienia, dodaj komunikaty o bledach
// zawarte (po sprawdzeniu formularza) w tablicy $form_check->errors_found
$theme->users_form($form,$form_check,"users_new.html.php");        

$theme->page_open_foot("page_open_1_foot");

// zapamietaj wywolanie tej strony
$global_lock_user=true;
$sess->register("global_lock_user",$global_lock_user);

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
