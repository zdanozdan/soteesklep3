<?php
/**
* Kasowanie bazy danych
*
* @author rdiak@sote.pl
* @version $Id: index.php,v 1.4 2005/01/20 14:59:17 maroslaw Exp $
* @package    admin_users
* @subpackage admindb
*/
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");
require_once ("./include/admindb.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->admindb_bar);

$admindb=new AdminDB;
$admindb->AdminDbAction();

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
