<?php
/**
 * Edycja wlasciwosci tematu
 * 
 * @author  m@sote.pl
 * @version $Id: themes.php,v 1.3 2005/01/20 15:00:12 maroslaw Exp $
* @package    themes
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./html/edit_themes.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
