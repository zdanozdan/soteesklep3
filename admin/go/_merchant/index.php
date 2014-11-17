<?php
/**
 * Zmiana danych sprzedawcy, adres, email na ktory przychodza zamowienia itp.
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.12 2005/06/09 08:47:28 maroslaw Exp $
 * @package    merchant
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Nag³ówek skryptu */
require_once ("../../../include/head.inc");

// obsluga generowania pliku konfiguracyjnego uzytkownika
require_once("include/gen_user_config.inc.php");

// obsluga sprawdzania formularzy
include_once("include/form_check.inc");
$form_check = new FormCheck;

// naglowek
$theme->head();
$theme->page_open_head();
include_once ("./include/menu.inc.php");

require_once ("include/forms.inc.php");


if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

if (! empty($_REQUEST['merchant'])) {
    $merchant=$_REQUEST['merchant'];reset($merchant);$m2=array();
    foreach ($merchant as $key=>$val) {        
        $m2[$key]=preg_replace('/\\\/i','\\\\',$val);        
    }    
    $merchant=$m2;
} else $merchant='';


if (! empty($_REQUEST['order_email'])) {
    $order_email=$_REQUEST['order_email'];
} else $order_email='';

if (! empty($_REQUEST['from_email'])) {
    $from_email=$_REQUEST['from_email'];
} else $from_email='';

if (! empty($_REQUEST['newsletter_email'])) {
    $newsletter_email=$_REQUEST['newsletter_email'];
} else $newsletter_email='';

if (! empty($_REQUEST['currency'])) {
    $currency=$_REQUEST['currency'];
} else $currency='';

if (! empty($_REQUEST['www'])) {
    $www=$_REQUEST['www'];
    $www=strtolower($www);
    if (eregi("http://",$www)) {
        $www=ereg_replace("http://","",$www);
    }
} else $www='';

// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    $ftp->connect();
    $gen_config->gen(array("merchant"=>$merchant,
    "order_email"=>$order_email,
    "from_email"=>$from_email,    
    "www"=>$www,    

    )
    );
    $ftp->close();
    $config->merchant=$merchant;
    $config->order_email=$order_email;
    $config->from_email=$from_email;    
    $config->www=$www;
}

include_once ("./html/merchant.html.php");


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
