<?php
/**
* Usuñ rekordy z tabeli newsedit_groups
*
* @author  m@sote.pl
* \@template_version Id: delete.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
* @version $Id: delete.php,v 1.4 2005/01/20 14:59:57 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->newsedit_groups_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("newsedit_groups","id");

$theme->page_open_foot();
$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
