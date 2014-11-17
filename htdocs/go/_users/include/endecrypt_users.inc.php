<?php
/**
 * Wygeneruj nowe haslo klienta. Wyslij klucz klientowi i przekoduj dane w tabeli users.
 * Jesli haslo jest przekazane to tylko koduj itp.
 *
 * \@global string $__email        email klienta (email jest w bazie i sei zgadza)
 * \@global int    $__id           id klienta z tabeli users
 * \@global string $__login        login klienta jw.
 * \@global addr   $__result       wskaznik na $result z bazy danych z zapytania o dane klienta z tabeli users
 * \@global string $__new_password nowe haslo klienta, jesli nie ma podanego nowego hasla, to wygeneruj haslo i wyslij je klientowi mailem
 * 
 * @author  m@sote.pl
 * @version $Id: endecrypt_users.inc.php,v 2.8 2004/12/20 18:01:54 maroslaw Exp $
* @package    users
 */

if (@$__secure_test!=true) die ("Forbidden");

// generuj losowe haslo 
if (@empty($__new_password)) {
    require_once("lib/PasswordGenerator/PasswordGenerator.php");
    $password_g = new PasswordGenerator(8,8);
    $rand_password = $password_g->getHTMLPassword();    

    // wyslij nowe haslo do klienta
    require_once ("lib/Mail/MyMail.php");
    $my_mail =& new MyMail;
    
    $to=$__email;
    $from=$config->from_email;
    $subject=$lang->users_remind_subject." ".$config->www;
    
    $body=$lang->users_remind_body;
    $body=ereg_replace("{PASSWORD}",$rand_password,$body);
    $body=ereg_replace("{LOGIN}",$__login,$body);
    $body=ereg_replace("{WWW}",$config->www,$body);
    $body=ereg_replace("{PROTOCOL}","http",$body);
    
    $reply=$from;
    $my_mail->send($from,$to,$subject,$body,$reply);
    
} else {
    $rand_password=$__new_password;   
}

$date_update=date("Y-m-d");
$last_ip=$_SERVER['REMOTE_ADDR'];
$global_id_user=$__id;

// @todo suma kontrolna
include_once ("./include/checksum.inc.php");
$checksum='';

/**
* Zapisz nowe dane w bazie.
*/
// require_once ("./include/update.inc.php");
// end

// koduj login i haslo (nowym kluczem)
$crypt_password=md5($rand_password); 
$query="UPDATE users SET crypt_password=? WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$crypt_password);
    $db->QuerySetInteger($prepared_query,2,$__id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // udalo sie zaktualizowac login i haslo klienta
    } else die ($db->Error());
} else die ($db->Error());
?>
