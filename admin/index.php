<?php
/**
 * Wywolanie glownej strony panelu administracyjnego
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 2.10 2005/02/22 15:17:22 maroslaw Exp $
* @package    default
 */

$global_database=true;$__start_page=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

@include_once ("../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->html_file("main.html");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>