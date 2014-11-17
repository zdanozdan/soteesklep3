<?php
/**
 * Export produktów do ceneo pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: index.php,v 1.2 2006/08/16 10:41:41 lukasz Exp $
* @package    pasaz.ceneo.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../include/head.inc");

$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->ceneo_bar["index"]);

include_once("./html/ceneo_pasaz.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
