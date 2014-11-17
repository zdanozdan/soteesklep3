<?php
/**
* Lista klientów w sklepie wg zapytania SQL 
*
* @author  m@sote.pl
* @version $Id: users_list.inc.php,v 2.4 2005/10/20 06:31:25 krzys Exp $
*
* \@global string $sql zapytania SQL o klientów
* @package    users
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

print "<form action=/go/_users/delete.php method=post name=FormUsers>";
include_once ("./include/menu.inc.php");
$theme->bar($lang->bar_title['users']);

/**
* Funkcja prezentujaca wynik zapytania w g³ownym oknie strony.
*/
include_once ("include/dbedit_list.inc");

$dbedit =& new DBEditList;
$dbedit->page_records=20;
$dbedit->page_links=20;

// ustal klase i funkcje generujaca wiersz rekordu
require_once("./include/users_record.inc.php");
require_once ("./include/list_th.inc.php");
$dbedit->start_list_element=users_list_th();
$dbedit->record_class="UsersRecordRow";
$dbedit->record_fun="record";
$dbedit->show();
print "</form>";

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
