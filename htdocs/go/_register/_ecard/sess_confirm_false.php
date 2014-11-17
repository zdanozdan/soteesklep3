<?php
/**
 * Brak potwierdzenia autoryzacji z eCardu
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("$DOCUMENT_ROOT/../include/head.inc");

$theme->head();

$theme->page_open_head("page_open_1_head");
$theme->bar($lang->bar_title['ecard']);
$theme->theme_file("_ecard/ecard_false.html.php");
$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
