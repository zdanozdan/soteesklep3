<?php
/**
 * Dodaj recenzje do tabeli reviews
 * 
 * @author piotrek@sote.pl
 * @version $Id: add.php,v 1.4 2005/01/20 15:00:36 maroslaw Exp $
* @package    reviews
 */

$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/form_check.inc");

$form_check = new FormCheck; 

// sprawdzanie poprawnosci pol formularza
$form_check->fun=array("score"=>"int");

// obsluga bledow
$form_check->errors=$lang->reviews_form_errors;

if(! empty($_POST['item'])) {
    $form=$_POST['item'];
} else $form=array();

if(! empty($_POST['update'])) {
    $update=$_POST['update'];
} else $update=false;

$form_check->form=&$form;

$theme->head_simple();
$theme->bar($lang->reviews_add_bar);

if ($update==true) {
    if($form_check->form_test()) {
        require_once("./include/insert.inc.php");
        exit;
    } else {
        // formularz zawiera bledy , wyswietl go jesczze raz
        include_once("./html/edit.html.php");
    }
} else {
    include_once("./html/edit.html.php");   // pierwsze wywolanie
}

$theme->foot_simple();

?>
