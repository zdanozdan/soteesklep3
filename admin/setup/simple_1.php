<?php
/**
 * Formularz uproszczonej instalacji
 * 
 * @author m@sote.pl
 * @version $Id: simple_1.php,v 2.10 2005/02/02 13:00:14 maroslaw Exp $
 *
 * @Verified 2004-03-16 m@sote.pl
* @package    setup
 */

$global_database=false;
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}
require_once ("../../include/head.inc");
// dodaj obsluge bazy danych
require_once "lib/Metabase/metabase_interface.php";
require_once "lib/Metabase/metabase_database.php";

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");

// odczytaj typ instalacji
if (! empty($_REQUEST['config'])) {
    $config_setup=$_REQUEST['config'];
    $sess->register("config_setup",$config_setup);
} elseif (! empty($_SESSION['config_setup'])) {
    $config_setup=$_SESSION['config_setup'];
} else {
    $config_setup=$config->config_setup;
}

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
    if ((@$config_setup['host']=="internet") && (@$shop->home!=1)) {
        $form['dbhost']=$_SERVER['HTTP_HOST'];
        $form['dbname']='';
        $form['ftp_host']=$_SERVER['HTTP_HOST'];
    } elseif (@$shop->home==1) {
        $form['dbhost']=$_SERVER['HTTP_HOST'];
        $form['dbname']='';
        $form['ftp_host']=$_SERVER['HTTP_HOST'];
    } else {
        $form['dbhost']='localhost';
        $form['dbname']='soteesklep3';
        $form['ftp_host']='localhost';   
    }
}

// definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
// (z klasy FormCheck)
$form_check->fun['dbhost']="dbhost";
$form_check->fun['dbname']="dbname";
$form_check->fun['admin_dbuser']="dbuser";
$form_check->fun['admin_dbpassword']="dbpassword";
$form_check->fun['ftp_host']="ftp_host";
$form_check->fun['ftp_user']="ftp_user";
$form_check->fun['ftp_password']="ftp_test";
$form_check->fun['pin']="pin";
$form_check->fun['pin2']="pin2";
$form_check->fun['license']="license";
$form_check->fun['license_who']="string";

// sprawdz czy jest to wywolanie wyswietlenia formularza, czy sprawdzenie
if (! empty($form['check'])) {
    $form['check']['license']=trim($form['check']['license']);
    $form_check->check=my($form['check']);
}

// tablica z komunikatami bledow
$form_check->errors=$lang->setup_simple_errors;

// sprawdz czy formularz jest poprawnie wyswietlony
// wymagane sa pola, ktore maja odpowiednia wartosc w $form_check->errors
// tj. maja przypisany komunikat o bledzie        
if ($form_check->check=="true") {
    if ($form_check->form_test()) {
        // poprawnie wypeniony formularz                
        include_once ("simple_2.php");
        exit;
    }
}  

$theme->form_check=&$form_check;
$theme->form=&$form;
include_once ("./html/simple_1.html.php");

include_once ("themes/base/base_theme/foot_setup.html.php");
// stopka
include_once ("include/foot.inc");
?>
