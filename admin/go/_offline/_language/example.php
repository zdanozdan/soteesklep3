<?php
/**
 * Przyklady cennika do aktualizacji
 *
 * @author  rdiak@sote.pl
 * @version $Id: example.php,v 1.1 2005/04/21 07:12:06 scalak Exp $
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
$theme->bar($lang->offline_example);

include ("./html/example.html.php");


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
