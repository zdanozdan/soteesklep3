<?php
/**
 * Wysy³anie wiadomosci e-mail z serwisu
 *
 * do poprawnego dzialania wymagane sa nastepujace obiekty:
 *     - Validate.php
 *     - form_check.inc 3.x>
 *     - session.inc    3.x>
 *     - MyMail.php
 * 
 * @author  rp@sote.pl
 * @version $Id: contact.php,v 1.5 2005/01/20 15:00:16 maroslaw Exp $
* @package    contact
 */
 
$global_database=true;
$global_secure_test=true; 

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// klasa obslugujaca sprawdzanie poprawnosci formularzy HTML
include_once ("include/form_check.inc");
$form_check = new FormCheck; 
$theme->form_check=&$form_check;

$form_check->fun['email']="email";
$form_check->fun['subject']="string";
$form_check->fun['content']="string";

// tablica z komunikatami bledow
include_once("./lang/_pl/lang.inc.php");
$form_check->errors=$lang->mail_form_errors;

if(!empty($_POST['form'])){
	$form=$_POST['form'];
	$form_check->form=&$form;
	$theme->form=&$form;
} else {
    // sprawdz czy jest zdefiniowany temat dla nowej wiadomosci
    if(!empty($_REQUEST['subject'])){
        $form['subject']=$_REQUEST['subject'];
    }
    $theme->form=&$form;
}

if(@$_REQUEST['send_mail']==1){    
    if($form_check->form_test()){        
        include_once("./include/send_mail.php");        
    } else {    
        include_once("html/mail_form.html.php");    
    }    
    
} else {
    include_once("html/mail_form.html.php");    
}

include_once ("include/foot.inc");
?>
