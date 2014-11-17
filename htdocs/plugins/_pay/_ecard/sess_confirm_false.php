<?php
/**
 * Brak potwierdzenia autoryzacji z eCardu
* @version    $Id: sess_confirm_false.php,v 1.3 2005/01/20 15:00:28 maroslaw Exp $
* @package    pay
* @subpackage ecard
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

$theme->head();

$theme->page_open_head("page_open_1_head");
$theme->bar($lang->bar_title['ecard']);
$theme->theme_file("_ecard/ecard_false.html.php");
$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
