<?php
/**
* Lista rekordów tabeli admin_users_type.
*
* @author m@sote.pl
* @version $Id: index.php,v 2.5 2005/01/20 14:59:17 maroslaw Exp $
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
include ("../lang/_$config->lang/lang.inc.php");
// end naglowek php

// config
$sql="SELECT * FROM admin_users_type ORDER BY id";
$bar=$lang->admin_users_type_list_bar;
require_once ("./include/list_th.inc.php");
$list_th=list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

/**
* Wy¶wietl listê rekordów.
*/
require_once ("include/list.inc.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
