<?php
/**
 * Wywolanie glownej strony panelu administracyjnego
 *
 * @author  m@sote.pl
 * @version $Id: index2.php,v 2.6 2005/01/20 14:59:16 maroslaw Exp $
* @package    default
 */

$global_database=true;$__start_page=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

include_once ("../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->html_file("main.html");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
