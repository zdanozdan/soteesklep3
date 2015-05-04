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
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.5 2007/12/01 10:47:30 tomasz Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];


require_once ("../../../include/head.inc");

// naglowek
//$theme->head();
//$theme->page_open_head("page_open_1_head");
$__no_head=false;
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
    require_once("./include/login.inc.php");
    $login = new LoginUsers;
    if ($login->login($form['login'],$form['password'])) 
    {
        $global_login=$form['login']; // nazwa zalogowanego uzytkownika
        // poprawne logowanie :)
        $form=&$login->form;                
                       
        // od wersji 3.0 global_prv_key = $public_key
        $global_prv_key=md5($config->salt);
        
        $sess->register("form",$form);
        //$sess->register("form_cor",$form_cor);
        $sess->register("global_prv_key",$global_prv_key);                    
        $sess->register("global_login",$global_login);
        $global_id_user = $_SESSION['global_id_user'];
        $res = $mdbd->select("id_partner", "users", "id=?", array($global_id_user => "int"), "", "array");// pobranie id partnera
        if (!empty($res[0]["id_partner"])) 
        {
           $id_partner = $res[0]["id_partner"];
           $sess->register("id_partner", $id_partner);
        }

        // naglowek
        //$theme->head();
        $theme->page_open_head("page_open_1_head");
        $__no_head=true;


        // dolacz menu dla panelu uzytkownika
        include_once("./include/menu.inc.php");
        if (!empty($_SESSION['id_partner']))
            $theme->bar($lang->users_partners['bar'] . $lang->users_bar);
        else
            $theme->bar($lang->users_bar);

        $theme->theme_file("users_login_ok.html.php");

        // zarejstruj w sesji zmienne zezwalajace na przejscie do strony podsumowania zamowienia
        $global_lock_basket=true;
        $global_lock_register=true;
        $sess->register("global_lock_bakset",$global_lock_basket);
        $sess->register("global_lock_register",$global_lock_register);
        $theme->theme_file("products4u.html.php");

    } else {
        // bledne logowanie :(
        if (!$__no_head) 
        {
           // naglowek
           //$theme->head();
           $theme->page_open_head("page_open_1_head");
        }
        $theme->theme_file("users_login_error.html.php");
    } 

    // zapamietaj wywolanie tej strony
    $global_lock_user=true;
    $sess->register("global_lock_user",$global_lock_user);
    
    $theme->page_open_foot("page_open_1_foot");

    
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
            if (!$__no_head) {
	        	// naglowek
	      //$theme->head();
				$theme->page_open_head("page_open_1_head");
	        }
            $new_login=$form['login'];
            $sess->register("new_login",$new_login);
            $head_open=true;
            include_once("register1.php");
            exit;
        }
    }
} 

// sprawdz czy uzytkownik jest juz zalogowany
if (! empty($_SESSION['global_id_user'])) {
    // uzytkownik jest juz zalogowany, pokaz panel uzytkwonika

    // dolacz menu dla panelu uzytkownika
    if (!$__no_head) {
        	// naglowek
      //$theme->head();
			$theme->page_open_head("page_open_1_head");
	}
    include_once("./include/menu.inc.php"); 
    $global_login=$_SESSION['global_id_user'];
    $theme->bar($lang->users_bar);
    $theme->theme_file("users_login_ok.html.php"); 

    
    //        print "<P><center><BR>";
    //    print $lang->users_bar;
    //     print "</center><BR></P>";
        $theme->theme_file("products4u.html.php");
          
} else {
   if (!$__no_head) {
      // naglowek
      //$theme->head();
      $theme->page_open_head("page_open_1_head");
   }
   // wypelniony (lub jesli jest to pierwsze wywolanie)
   // w przypadku zlego wypelnienia, dodaj komunikaty o bledach
   // zawarte (po sprawdzeniu formularza) w tablicy $form_check->errors_found
   $theme->users_form($form,$form_check,"users.html.php");     
}

//$theme->page_open_foot("page_open_1_foot");

// zapamietaj wywolanie tej strony
$global_lock_user=true;
$sess->register("global_lock_user",$global_lock_user);

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
