<?php
/**
* Wyslij pliki rozliczeniowe PolCardu CFC i wyslij pliki CFD. Na GET wyswietl CFC na POST przyjmij CFD
*
* @author  m@sote.pl
* @version $Id: adv_poll.php,v 1.6 2005/01/20 15:00:32 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

// w httpd.conf w apache nalezy ustawic wymaganie, waznego i podpisanego przez znane CA, certyfikatu SSL dla tego pliku
// lub wywolac ponizszy kod
/**
* Weryfikacja certyfikatu SSL klienta.
*/
require_once ("./include/check_ssl.inc.php");

header ("Content-type: text/plain");

// wymagaj wywolania przez HTTPS
if (empty($_SERVER['HTTPS'])) die ("Forbidden");
if ($_SERVER['HTTPS']!="on") die ("Forbidden");

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/polcard_config.inc.php"); // konfiguracja klienta
require_once ("./config/config.inc.php");                   // konfiguracja parametrow ssl
require_once ("./include/polcard.inc.php");
require_once ("include/order_register.inc");                // funkcja obliczania sumy kontrolnej
require_once ("include/my_crypt.inc");

if (empty($_FILES['clearing_report_file'])) {
    // wyslij CFC
    require_once("./include/cfc.inc.php");
    $cfc = new CFC;
    // odczytaj w jakie dni byly zawarte jakies transakcje
    $days=$cfc->get_days();                                 // array('2003-08-26','2003-08-27',...)
    //print_r($days);
    
    reset($days);
    foreach ($days as $day) {
        $cfc_file=$cfc->gen_cfc($day);
        if ($cfc_file)  {
            print $cfc_file;
            exit;
        }
    } // end foreach
} else {
    // odbierz CFD
    require_once ("./include/cfd.inc.php");
}

exit;

// stopka
include_once ("include/foot.inc");
?>
