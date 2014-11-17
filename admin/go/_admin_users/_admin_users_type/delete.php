<?php
/**
* Usuñ rekordy z tabeli admin_users_type.
*
* @author m@sote.pl
* @version $Id: delete.php,v 2.5 2005/01/20 14:59:17 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");
// end naglowek php

@include_once ("../lang/_$config->base_lang/lang.inc.php");
@include_once ("../lang/_$config->lang/lang.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

/**
* Menu.
*/
include_once ("./include/menu.inc.php");
$theme->bar($lang->admin_users_type_bar);
print "<p>";

/**
* Klasa Delete.
*/
require_once("include/delete.inc.php");
$delete = new Delete;
// usuñ zaznaczone rekordy.
$delete->delete_all("admin_users_type","id");

$theme->page_open_foot();

$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
