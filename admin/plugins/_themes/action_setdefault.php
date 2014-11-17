<?php
/**
 * Ustawienie domy¶lnego tematu w sklepie
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


if (! empty($_REQUEST['thm'])) {
    $__thm=$_REQUEST['thm']; // klucz reprezentuj±cy wybrany temat
} else die ("Forbidden");

// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    $ftp->connect();    
    $gen_config->gen( array("theme"=>$__thm) );
    $ftp->close();
    $config->theme=$__thm;
}

include_once ("./html/action_setdefault.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");


?>
