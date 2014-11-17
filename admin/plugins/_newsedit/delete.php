<?php
/**
* Usuñ zaznaczone newsy.
*
* @author  m@sote.pl
* @version $Id: delete.php,v 2.4 2005/01/20 14:59:56 maroslaw Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->newsedit_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("newsedit","id");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
