<?php
/**
 * Aktualizuj dane klienta
 *
 * \@depend ../register3.php
 * \@depend endecrypt_users.inc.php
 *
 * @return bool $__update_result true udalo sie zaktualizowac dane
 * 
 * @author  m@sote.pl
 * @version $Id: update.inc.php,v 2.9 2005/12/05 12:48:18 krzys Exp $
* @package    users
 */

if (@$__secure_test!=true) die ("Forbidden");

$__update_result=false;
$query="UPDATE users SET crypt_firm=?, crypt_name=?, crypt_surname=?, crypt_street=?, crypt_street_n1=?, crypt_street_n2=?, crypt_postcode=?, crypt_city=?, crypt_nip=?, crypt_phone=?, crypt_email=?, crypt_country=?, date_update=?, last_ip=?, checksum=?, crypt_user_description=? WHERE id=?";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$crypt_firm);
    $db->QuerySetText($prepared_query,2,$crypt_name);
    $db->QuerySetText($prepared_query,3,$crypt_surname);
    $db->QuerySetText($prepared_query,4,$crypt_street);
    $db->QuerySetText($prepared_query,5,$crypt_street_n1);
    $db->QuerySetText($prepared_query,6,$crypt_street_n2);
    $db->QuerySetText($prepared_query,7,$crypt_postcode);
    $db->QuerySetText($prepared_query,8,$crypt_city);
    $db->QuerySetText($prepared_query,9,$crypt_nip);
    $db->QuerySetText($prepared_query,10,$crypt_phone);
    $db->QuerySetText($prepared_query,11,$crypt_email);
    $db->QuerySetText($prepared_query,12,$crypt_country);
    $db->QuerySetText($prepared_query,13,$date_update);
    $db->QuerySetText($prepared_query,14,$last_ip);
    $db->QuerySetText($prepared_query,15,$checksum);
    $db->QuerySetText($prepared_query,16,$crypt_user_description);
    $db->QuerySetText($prepared_query,17,$global_id_user);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $__update_result=true;
    } else die ($db->Error());
} else die ($db->Error());

if ($_REQUEST['form']['news']=='yes'){
//dodaj adres do bazy newsletter
require_once ("include/newsletter_add.inc");
global $config;
$date_add=date("Y-m-d");
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;
$email2news=$my_crypt->endecrypt("",$crypt_email,"de");
add_2_newsletter($email2news,$date_add,1,1,@$email_md5,":1:",$config->lang);}
?>
