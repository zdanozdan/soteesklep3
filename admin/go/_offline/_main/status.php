<?php
/**
 * Status wykonia �adowania offline
 *
 * @author  rdiak@sote.pl
 * @version $Id: status.php,v 2.5 2005/01/20 14:59:28 maroslaw Exp $
* @package    offline
* @subpackage main
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag��wek skryptu
 */
require_once ("../../../../include/head.inc");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->offline_status);

// zapisz dane w pliku sesji, dane sesyjne przekazywane do skryptow w Perlu
require_once ("./include/status.inc.php");
require_once ("./html/status.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
