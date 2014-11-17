<?php
/**
 * Export danych
 *
 * @author  rdiak@sote.pl
 * @version $Id: index.php,v 1.8 2005/01/20 14:59:28 maroslaw Exp $
* @package    offline
* @subpackage export
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Includowanie potrzebnych klas 
 */
require_once ("../../../../include/head.inc");
include_once ("$DOCUMENT_ROOT/go/_offline/_main/config/config.inc.php");
require_once ("include/save_auth_session.inc.php");

$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->export_status);

require_once ("./html/export.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
