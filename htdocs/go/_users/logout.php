<?php
/**
 * Wyloguj uzytkwownika                                                 |
 *
 * @author m@sote.pl
 * @version $Id: logout.php,v 2.5 2005/03/29 15:35:35 lechu Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

// wyloguj uzytkownika
require_once("./include/logout.inc.php");
$logout->logout_all();

// naglowek
//$theme->head();
$theme->page_open_head("page_open_1_head");
$theme->bar($lang->bar_title['users']);

$theme->theme_file("users_logout.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>