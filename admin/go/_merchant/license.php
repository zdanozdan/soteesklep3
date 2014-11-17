<?php

/**
* Zmiana licencji i nazwy firmy 
*
* @author  krzys@sote.pl
* @version $Id: license.php,v 1.2 2005/01/20 14:59:26 maroslaw Exp $
* @package    merchant
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu 
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkownika.
*/
require_once("include/gen_user_config.inc.php");

/**
* Obs³uga sprawdzania formularzy
*/ 
include_once("include/form_check.inc");
$form_check = new FormCheck;

// naglowek
$theme->head();
$theme->page_open_head();
include_once ("./include/menu.inc.php");
$theme->bar($lang->licence_title,"100%");print "<BR>";
/**
* Obs³uga srawdzania poprawno¶ci licencji
*/ 
require_once ("include/license.inc.php");

$configure=array();
if (! empty($_REQUEST['license']['nr'])) {
    $configure['nr']=trim($_REQUEST['license']['nr']);
}
if (! empty($_REQUEST['license']['who'])) {
    $configure['who']=trim($_REQUEST['license']['who']);
}

// Sprawdanie poprawno¶ci wprowadzonej licencji
$lic =& new License;
$check_license = $lic->check($_REQUEST['license']['nr']);

if ($check_license==1){

    $ftp->connect();
    $gen_config->gen(array("license"=>$configure));
    $ftp->close();
    $config->licence=$configure;

    print "<b><font color=\"green\">".$lang->merchant_license_ok."</b></font><br><br>";
    print "<table border=0><tr><td>";
    print $lang->merchant_license_nr_act.":</td> <td><b>".$configure['nr']."</b></td></tr><tr><td>";
    print $lang->merchant_license_who_act.":</td> <td><b>".$configure['who']."</b></td></tr></table>";
    // wpisanie licencji do sesji         
    $license=$configure;
    $sess->register("license",$license);
           
    $theme->go2main("/go/_merchant/index.php",3);    
}else{

    $theme->back();
    $theme->go2main("/go/_merchant/index.php",3);  
    print "<b><font color=\"red\">".$lang->merchant_license_bad."</b></font>";
}

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>