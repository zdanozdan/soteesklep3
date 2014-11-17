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
 * @version $Id: send_mail.php,v 1.5 2004/12/20 18:01:38 maroslaw Exp $
* @package    contact
 */

if(!empty($_REQUEST['form'])) {
    $data=$_REQUEST['form']; 
} else {
    $theme->go2main();
    exit;
}

/**
* adres odbiorcy wiadomosci e-mail
*/
global $config;
$form_to=$config->from_email;
$form_email=$data['email'];
$form_subject=$data['subject'];
$form_content=$data['content'];

require_once("Mail/MyMail.php");
$mail=new MyMail;

if(!$sess->reload()){

    $send_status=$mail->send($form_email,$form_to,$form_subject,$form_content);
    // sprawdz czy strona z formularzem pochodzi z glownego wywolania
    // np: dzialu glownego kontakt czy jest to zapytanie z okienka
    if(!empty($main_contact)){
        if($send_status==true){
            include_once("html/main_send_ok.html.php");    
        } else {
            include_once("html/main_send_no.html.php");
        }
    } else {
        if($send_status==true){        
            include_once("html/send_ok.html.php");    
        } else {
            include_once("html/send_no.html.php");
        }
    }    
} else {
    unset($theme->form);
    include_once("html/main_mail_form.html.php");
}   

?>
