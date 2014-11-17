<?php
/**
* Usuñ zaznaczone grupy newslettera.
*
* @author  rdiak@sote.pl
* @version $Id: delete.php,v 2.7 2005/01/20 14:59:58 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->newsletter_delete_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("newsletter_groups","id");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
