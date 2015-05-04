<?php
/**
 * Zmien haslo klienta - formularz
 *
 * @author  m@sote.pl
 * @version $Id: password.php,v 2.5 2006/01/20 10:57:36 lechu Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// sprawdz, czy klient jest zalogowany, jesli nie to wyswietl formularz logowania
if (empty($_SESSION['global_id_user'])) {
    include_once ("./index.php");
    exit;
}

// naglowek
//$theme->head();
$theme->page_open_head("page_open_1_head");

include_once ("./include/menu.inc.php");

if (!empty($_SESSION['id_partner']))
    $theme->bar($lang->users_partners['bar'] . $lang->users_remind_title);
else
    $theme->bar($lang->users_remind_title);

require_once ("./include/my_form_check.inc.php");
$form_check = new MyFormCheck;

$form_check->fun=array("old_password"=>"old_password",
                       "password"    =>"password",
                       "password2"   =>"confirm_password"
                       );

$form_check->errors=$lang->users_password_errors;

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
    $form_check->form=&$item;
} 

if (@$_REQUEST['update']==true) {
    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once ("./include/change_password.inc.php");
        $theme->theme_file("_users/password_changed.html.php");
    } else {
        // blednie wypelniony formularz
        $theme->form_check=&$form_check;
        $theme->form=&$item;
        $theme->theme_file("_users/password.html.php"); 
    }
} else {
    $theme->theme_file("_users/password.html.php"); 
}

$theme->theme_file("products4u.html.php");

$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
