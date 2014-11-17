<?php
/**
 * Aktualizacja offline, menu +info
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 2.7 2005/01/20 14:59:26 maroslaw Exp $
* @package    offline
 */ 

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->offline_title);

/* info o imporcie i exporcie */
include_once ("./html/offline.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
