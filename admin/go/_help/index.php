<?php
/**
 * Dokumentacja g³ówna sklepu.
 *
 * @author m@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 14:59:24 maroslaw Exp $
* @package    help
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Nag³ówek skryptu */
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();


$theme->bar($lang->help_title);
include_once ("./html/help.html.php");

$theme->page_open_foot();
$theme->foot();
include_once ("include/foot.inc");
?>
