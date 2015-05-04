<?php
/**
 * Ksiazka adresowa zalogowanego uzytkownika (formularz do wporwadzania danych)
 * 
 * @author  m@sote.pl
 * @version $Id: address_book1.php,v 1.9 2005/01/20 15:00:21 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");


// naglowek
if(empty($__open_head)){
  //$theme->head();
  $theme->page_open_head("page_open_1_head");
}

include_once("./include/menu.inc.php"); 
$theme->bar($lang->bar_title['address_book']);    

require_once("include/form_check.inc");
require_once("./include/form_check_functions.inc.php");

$form_check=new FormCheckFunctions;
$theme->form_check=&$form_check;

// definiuj funckje sprawdzajace poprawnosc wartosci pola z formularza
// (z klasy FormCheckFunctions)
$form_check->fun['firm']="null";
$form_check->fun['name']="string";
$form_check->fun['surname']="string";
$form_check->fun['street']="string";
$form_check->fun['street_n1']="string";
$form_check->fun['street_n2']="string";
$form_check->fun['postcode']="string";
$form_check->fun['city']="string";
$form_check->fun['email']="emailXtd";
$form_check->fun['phone']="null";
$form_check->fun['country']="null";

// tablica z komunikatami bledow
$form_check->errors=$lang->register_cor_form_errors;

if(!empty($_POST['form_cor'])){    
	$form=$_POST['form_cor'];
	$form_check->form=&$form;
	$theme->form=&$form;
}
$theme->action="address_book1.php";

if(@$_REQUEST['update']==true){
	if($form_check->form_test()){
		$__bar=true;
		$__open_head=true;
		require_once("address_book2.php");
		exit;
	} else {	    
		$theme->theme_file("_users/address_book/address_book_cor.html.php");   
	}
} else {
	$theme->theme_file("_users/address_book/address_book_cor.html.php");   
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
