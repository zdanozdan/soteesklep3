<?php
/**
* Obsluga modulu CD, wlaczenie systemu generowania wersji off-line sklepu
* dla wybranego IP
*
* @author  m@sote.pl
* @version $Id: index.php,v 1.5 2005/01/20 14:59:45 maroslaw Exp $
* @package    cd
*/

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../include/head.inc");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");

// obsluga sprawdzania formularzy
include_once("include/form_check.inc");
$form_check = new FormCheck;

if (! empty($_REQUEST['item']['cd'])) {
    if (! empty($_REQUEST['item']['hurt'])) {
        $_REQUEST['item']['hurt']=1;
    }
    $cd=array("cd"=>"1","IP"=>$_SERVER['REMOTE_ADDR'],
    "price"=>$_REQUEST['item']['price'],"hurt"=>$_REQUEST['item']['hurt']);
} else $cd=array("cd"=>"0","IP"=>'','price'=>'',"hurt"=>'');

// naglowek
$theme->head();
$theme->page_open_head();

// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    $ftp->connect();
    $gen_config->gen(array("cd_setup"=>$cd));
    $ftp->close();
    $config->cd_setup=$cd;
}

require_once ("HTML/Form.php");
include_once ("./html/cd.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
