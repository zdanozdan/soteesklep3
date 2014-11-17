<?php
/**
* Edytuj rekord z tabeli admin_users_type.
*
* @author m@sote.pl
* @version $Id: edit.php,v 2.4 2005/01/20 14:59:17 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");
// end naglowek php
require_once ("config/auto_config/perm_config.inc.php");

$theme->head_window();
$theme->bar($lang->admin_users_type_update_bar);

require_once("include/mod_table.inc.php");

$mod_table = new ModTable;
$mod_table->update("admin_users_type","",array("type"=>"string"),
$lang->admin_users_type_form_errors
);

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
