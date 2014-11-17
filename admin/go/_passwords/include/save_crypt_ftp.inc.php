<?php
/**
 * Zakoduj i zapisz w bazie dane polaczenia FTP.
* @version    $Id: save_crypt_ftp.inc.php,v 2.2 2004/12/20 17:59:00 maroslaw Exp $
* @package    passwords
 */

require_once ("lib/RC4Crypt/class.rc4crypt.php");
$rc4 = new rc4crypt;

$pass = md5($global_auth_sign.$_SERVER['PHP_AUTH_PW']);
$data = $config->ftp_password;

// zakodowane haslo dostepu do FTP
$code=$rc4->endecrypt($pass, $data, "");

// zapisz dane w bazie
$query="UPDATE admin_auth SET value=? WHERE name='ftp_password'";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$code);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // OK
    } else die ($db->Error());
} else die ($db->Error());
?>
