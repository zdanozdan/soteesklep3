<?php
/**
 * W³±czenie obs³ugi wielu tematów
 *
 * @author     amiklosz@sote.pl
 * @version    $Id
* @package    themes
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// obsluga generowania pliku konfiguracyjnego uzytkownika
require_once("include/gen_user_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();


if ( !empty($_REQUEST['active'])) {
  $active = $_REQUEST['active'];
}
else {
  //$active['base_theme']=1;
  $active[$config->theme] = 1;
}


if (! empty($_REQUEST['update'])) {
    $ftp->connect();    
    $gen_config->gen( array("themes_active"=>$active) );
    $ftp->close();
    $config->themes_active = $active;
}


include_once ("./html/action_choose.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");


?>
