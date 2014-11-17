<?php
/**
* Edytuj rekord z tabeli admin_users.
*
* @author m@sote.pl
* @version $Id: edit.php,v 2.6 2005/07/12 13:25:52 lukasz Exp $
* @package    admin_users
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
// end naglowek php

/**
* Dodaj obs³uge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
*/
require_once ("include/ftp.inc.php");

$theme->head_window();
$theme->bar($lang->admin_users_update_bar);

/**
* Obs³uga edycji formularza
*/
require_once("include/mod_table.inc.php");

$mod_table =& new ModTable;
$mod_table->update("admin_users","",array("id"=>"id",
"id_admin_users_type"=>"id_admin_users_type",
"login"=>"login",
"password"=>"password",
"new_password"=>"new_password",
"new_password2"=>"new_password"),
$lang->admin_users_form_errors
);

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
