<?php
/**
 * Pomoc dla opcji "Edycja wygl±du"
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

include_once ("./html/help.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");


?>
