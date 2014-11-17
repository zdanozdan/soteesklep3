<?php
/**
* Dodaj rekord do tabeli admin_users.
* Dodanie rekordu powoduje dodanie nowego u¿ytkownika obs³uguj±cego sklep. 
* Oprócz dodania do bazy danych, odpowiedni wpis musi znale¼æ siê te¿ w pliku admin/.htaccess.
* W/w operacja jest dokonywana automatycznie przy dodaniu nowego u¿ytkownika.
*
* @author m@sote.pl
* @version $Id: add.php,v 2.6 2005/07/12 12:01:00 lukasz Exp $
* @package    admin_users
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu
*/
require_once ("../../../include/head.inc");
// end naglowek php

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");

$theme->head_window();
$theme->bar($lang->admin_users_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("admin_users","",array("id"=>"id",
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
