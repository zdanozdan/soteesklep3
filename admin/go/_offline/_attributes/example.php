<?php
/**
 * Przyklady cennika do aktualizacji
 *
 * @author  m@sote.pl
 * @version $Id: example.php,v 1.5 2005/01/20 14:59:27 maroslaw Exp $
* @package    offline
* @subpackage attributes
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->offline_example);

include ("./html/example.html.php");


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
