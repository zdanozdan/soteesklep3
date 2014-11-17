<?php
/**
* Brak potwierdzenia autoryzacji
*
* @author m@sote.pl
* @version $Id: sess_confirm_false.php,v 1.5 2005/01/20 15:00:33 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");

$theme->head();

$theme->page_open_head("page_open_1_head");
$theme->bar($lang->bar_title['polcard']);
$theme->theme_file("_polcard/polcard_false.html.php");
$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
