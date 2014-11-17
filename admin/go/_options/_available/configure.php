<?php
/**
 * Lista dostepnosci produktow w sklepie
 *
 * @author  m@sote.pl
 * @version $Id: configure.php,v 1.1 2006/01/03 09:14:20 lechu Exp $
* @package    options
* @subpackage available
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

$intervals_changed = @$_REQUEST['intervals_changed'];
// naglowek
$theme->head();
$theme->page_open_head();


include_once ("./include/menu.inc.php");

$intervals_by_from = array();
$intervals = array();
$error_intervals_message = '';

$theme->bar($lang->available_menu['configure']);
if (!empty($_REQUEST['form'])) {
    
    include_once("./include/configure.inc.php");
}
include_once("./html/configure.html.php");

$theme->page_open_foot();


// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
