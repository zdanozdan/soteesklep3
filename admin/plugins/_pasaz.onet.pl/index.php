<?php
/**
 * Export produktów do onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: index.php,v 1.5 2005/01/20 15:00:03 maroslaw Exp $
* @package    pasaz.onet.pl
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
$theme->bar($lang->onet_bar["index"]);

include_once("./html/onet_pasaz.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
