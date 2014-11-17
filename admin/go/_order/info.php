<?php
/**
 * Dodatkowe informacja zwi±zane z transakcj±
 *
 * @author  m@sote.pl
 * @version $Id: info.php,v 2.4 2005/01/20 14:59:34 maroslaw Exp $
* @package    order
 */
 
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
require_once ("./include/get_order_id.inc.php");

/**
* Odczytaj dane transakcji.
*/
require_once ("./include/select.inc.php");

$theme->head_window();
/**
* Menu z linkami (wyszukianie, lista transkacji itp).
*/
include_once("./include/menu_edit.inc.php");
$theme->bar($lang->order_info_title);


include_once ("./html/info.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>
