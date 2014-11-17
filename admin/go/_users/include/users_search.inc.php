<?php
/**
 * Generuj SQL, zapytanie wyszukiwania uzytkownikow
 *
 * @return string $sql
* @version    $Id: users_search.inc.php,v 2.7 2005/07/18 07:08:34 lukasz Exp $
* @package    users
 */

require_once("include/upper_lower_name.inc");
require_once ("include/my_crypt.inc");                                                                                        
$my_crypt = new MyCrypt;   

if (@$global_secure_test!=true) {
    die ("Bledne wywolanie1");
}

// odczytaj parametry

if (! empty($_REQUEST['form'])) {
    $form=$_REQUEST['form'];
} else die ("Bledne wywolanie2");

if (! empty($_REQUEST['from'])) $from=$_REQUEST['from'];
else die ("Bledne wywolanie3");

if (! empty($_REQUEST['to'])) $to=$_REQUEST['to'];
else die ("Bledne wywolanie4");

if (strlen($from['month'])==1) $from['month']="0".$from['month'];
if (strlen($from['day'])==1) $from['day']="0".$from['day'];
if (strlen($to['month'])==1) $to['month']="0".$to['month'];
if (strlen($to['day'])==1) $to['day']="0".$to['day'];

$date_from=$from['year']."-".$from['month']."-".$from['day'];
$date_to=$to['year']."-".$to['month']."-".$to['day'];

// sprawdz spojnik [i|lub]
if ($form['and']==1) {
    $conjuction="and";
} else $conjuction="or";

// czy sprawdzac date?
if (@$form['search_date']==1) {
    $search_date=1;
} else $search_date=0;

if (! empty($_REQUEST['form'])) {
    $form=$_REQUEST['form'];
}

$sql="SELECT * FROM users WHERE 1=1 AND record_version='30' ";

$if=false;
if ($search_date==1) {
    $sql.=" $conjuction ((date_add>'$date_from' and date_add<'$date_to') or (date_add='$date_from') or (date_add='$date_to'))";
    $if=true;
}

// imie
if (! empty($form['login'])) {
    $login=$form['login'];    
    $crypt_login=$my_crypt->endecrypt("",$login);    
    $sql.=" $conjuction crypt_login='$crypt_login'";
    $if=true;
}

// imie
if (! empty($form['name'])) {
    $name=$form['name'];     
    $name2=upper_lower_name($name);
    $crypt_name=$my_crypt->endecrypt("",$name2);    
    $sql.=" $conjuction crypt_name='$crypt_name'";
    $if=true;
}

// nazwisko
if (! empty($form['surname'])) {
    $surname=$form['surname'];     
    $surname2=upper_lower_name($surname);
    $crypt_surname=$my_crypt->endecrypt("",$surname2);    
    $sql.=" $conjuction crypt_surname='$crypt_surname'";
    $if=true;
}

// email
if (! empty($form['email'])) {
    $email2=$form['email'];     
//    $email2=strtolower($email);
    $crypt_email=$my_crypt->endecrypt("",$email2);    
    $sql.=" $conjuction crypt_email='$crypt_email'";
    $if=true;
}

// order_data
if (! empty($form['order_data'])) {
//    $sql.=" $conjuction order_data=1";
    $if=true;
} else {
    $sql.=" $conjuction order_data=0";   
}


// jesli nic nie zostalo wybrane, to generuj zapytanie zawsze falszywe - lista pusta
if ($if==false) {
    $sql.=" and 1=2";
}

// print "sql=$sql <BR>";

?>
