<?php
/**
* Weryfikuj certyfikat SSL polcardu
*
* @author  m@sote.pl
* @version $Id: check_ssl.inc.php,v 1.4 2004/12/20 18:02:10 maroslaw Exp $
*
* @todo dodaæ weryfikacjê danych sertyfikactu na podtswie ./config/config.inc.php
* @package    pay
* @subpackage polcard
*/

if (
(eregi("PolCard S.A.",@$_SERVER['SSL_CLIENT_S_DN_O'])) &&
(eregi("Warszawa",@$_SERVER['SSL_CLIENT_S_DN_L'])) &&
(@$_SERVER['SSL_CLIENT_S_DN_CN']=="post.polcard.com.pl") &&
(eregi("PolCard S.A.",@$_SERVER['SSL_CLIENT_I_DN_O'])) &&
(eregi("PolCard S.A. Test CA",@$_SERVER['SSL_CLIENT_I_DN_CN'])) &&
(eregi("PL",@$_SERVER['SSL_CLIENT_I_DN_C']))
)
{
    // poprawna weryfikacja certyfiktu SSL klienta
} else {
    die("Client Authentication Failed");
    /*
    // zapisanie certyfikatu odebranego z polcardu
    $fd=fopen ("/home/europolcard_logs/logs_cert.txt","w+");
    $d="_SERVER['SSL_CLIENT_S_DN_O']=".$_SERVER['SSL_CLIENT_S_DN_O']."\n";
    $d.="_SERVER['SSL_CLIENT_S_DN_L']=".$_SERVER['SSL_CLIENT_S_DN_L']."\n";
    $d.="_SERVER['SSL_CLIENT_S_DN_CN']=".$_SERVER['SSL_CLIENT_S_DN_CN']."\n";
    $d.="_SERVER['SSL_CLIENT_I_DN_O']=".$_SERVER['SSL_CLIENT_I_DN_O']."\n";
    $d.="_SERVER['SSL_CLIENT_I_DN_L']=".$_SERVER['SSL_CLIENT_I_DN_L']."\n";
    $d.="_SERVER['SSL_CLIENT_i_DN_CN']=".$_SERVER['SSL_CLIENT_I_DN_CN']."\n";
    fwrite($fd,$d,strlen($d));
    fclose($fd);
    */
}


?>
