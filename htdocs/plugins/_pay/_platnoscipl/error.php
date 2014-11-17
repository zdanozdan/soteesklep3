<?php
/**
* Powrót po rezygnacji z p³atno¶ci przelewy24.pl
*
* @author m@sote.pl
* @version $Id: error.php,v 1.2 2006/05/30 10:18:51 lukasz Exp $
* @package przelewy24
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

$theme->theme_file("_platnosciPL/platnosciPL_false.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
