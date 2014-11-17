<?php
/**
* Usuñ rekordy z tabeli admin_users.
*
* @author m@sote.pl
* @version $Id: delete.php,v 2.6 2005/01/20 14:59:16 maroslaw Exp $
* @package    admin_users
*/

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³owek skryptu
*/
require_once ("../../../include/head.inc");
// end naglowek php


// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->admin_users_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("admin_users","id");

$theme->page_open_foot();

$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
