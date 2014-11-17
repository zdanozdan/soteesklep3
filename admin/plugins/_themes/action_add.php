<?php
/**
 * Dodanie nowego tematu bazuj±cego na wybranym temacie
 *
 * @author     amiklosz@sote.pl
 * @version    $Id
* @package    themes
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");





// naglowek
$theme->head();
$theme->page_open_head();

print "<PRE>";
print_r($_REQUEST);
print "</PRE>";

include_once ("./html/actionAdd.html.php");



$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");


?>
