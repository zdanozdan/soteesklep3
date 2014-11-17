<?php
/**
 * Terminarz zalogowanego uzytkownika (formularz do wporwadzania danych)
 * 
 * @author  m@sote.pl
 * @version $Id: reminder3.php,v 1.4 2005/01/20 15:00:25 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

require_once("./include/reminder.inc.php");
$user_reminder=new UserReminder;
$theme->user_reminder=&$user_reminder;

// naglowek
if(empty($__open_head)){
  $theme->head();
  $theme->page_open_head("page_open_1_head");
}

include_once("./include/menu.inc.php"); 
$theme->bar($lang->bar_title['reminder']);    

require_once("include/form_check.inc");
require_once("./include/form_check_functions.inc.php");

$form_check=new FormCheckFunctions;
$theme->form_check=&$form_check;

// definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
// (z klasy FormCheckFunctions)
$form_check->fun['month']="int";
$form_check->fun['day']="int";
$form_check->fun['occasion']="string";
$form_check->fun['event']="string";
$form_check->fun['advise']="string";
$form_check->fun['handling1']="intExt";
$form_check->fun['handling2']="intExt";
$form_check->fun['handling3']="intExt";

// tablica z komunikatami bledow
$form_check->errors=$lang->reminder_form_errors;

$edit_data=$user_reminder->editRecord();

// wypelnij pola formularza danymi
if(!empty($_POST['reminder'])){       
	$form=$_POST['reminder'];
	$form_check->form=&$form;
	$theme->form=&$form;
}

if(!empty($edit_data)){       
	$form=$edit_data;
	$form_check->form=&$form;
	$theme->form=&$form;
}

// adres dla formularza
$theme->action="reminder3.php";

if(@$_REQUEST['update']==true){
	if($form_check->form_test()){
		$__bar=true;
		$__open_head=true;
		require_once("reminder4.php");
		exit;
	} else {
		$theme->theme_file("_users/reminder/reminder_add_form.html.php");
	}
} else {
	$theme->theme_file("_users/reminder/reminder_add_form.html.php");
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
