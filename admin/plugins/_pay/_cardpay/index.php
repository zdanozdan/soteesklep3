<?php
/**
 * Konfiguracja danych Przelewy24.pl, aktywacja/ustawienia uslugi
 *
 * @author  lukasz@sote.pl
 * @version $Id: index.php,v 1.10 2005/12/08 10:13:46 lukasz Exp $
 * @package    pay
 * @subpackage cardpay
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("config/auto_config/cardpay_config.inc.php");

// obsluga sprawdzania formularzy
include_once("include/form_check.inc");
$form_check = new FormCheck;

// naglowek
$theme->head();
$theme->page_open_head();

/**
* Obs³uga formularza
*/
require_once ("include/forms.inc.php");

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

$active=@$item['active'];
// zapisz dane w pliku konfiguracyjnym usera
// wszystko jest niedostepne jezeli nie ma modulu bcmath !!!
$available=true;
if (!function_exists('bcadd')) {
	$available=false;
	$errors[]="bcmath";
}
if (!@$config->ssl) {
	$available=false;
	$errors[]="config-ssl";
}
if (! empty($_POST['update_ssl'])) {
	require_once("include/gen_user_config.inc.php");
    $gen_config->auto_ftp=false;
    global $ftp;
    $ftp->connect();
    $config->ssl=$item['active'];
    $gen_config->gen(array(
                           "ssl"=>$config->ssl,
                           )
                     );
	$ftp->close();
	$errors="";
	$available=true;
} elseif (! empty($_REQUEST['update']) && $available) {
   
	require_once("include/gen_user_config.inc.php");
    $gen_config->auto_ftp=false;
    global $ftp;
    $ftp->connect();
    
    // jezeli nie mamy ssl'a - wylacz
    // jezeli nie mamy bcmath - wylacz
    // jezeli taki byl wybor usera - wylacz
    if (!$active) $active="0";
    $config->pay_method['110']="P³atno¶æ Kart±";
    $config->pay_method_active['110']=$active;
    $gen_config->gen(array(
                           "pay_method_active"=>$config->pay_method_active,
                           "pay_method"=>$config->pay_method,
                           )
                     );
    
    include "./include/local_gen_config.inc.php";
    $gen_config->gen(array("active"=>$active
                           )
                     );
    $ftp->close();
    $cardpay_config->active=$active;
}
include_once ("./html/cardpay.html.php");
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
