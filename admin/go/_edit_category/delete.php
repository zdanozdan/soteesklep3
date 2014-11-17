<?php
/**
 * Usun rekordy z tabeli edit_category
 * 
 * @author  m@sote.pl
 * \@template_version Id: delete.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: delete.php,v 1.3 2005/01/20 14:59:23 maroslaw Exp $
* @package    edit_category
 */

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

if (ereg("^[0-9]+$",@$_REQUEST['deep'])) {
    $deep=$_REQUEST['deep'];
} else $deep=1;
$__deep=&$deep;

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->edit_category_bar);
print "<p>";

// sprawdz ktore rekordy mozna usunac, zmodyfikuj $_REQUEST['del'] 
include ("./include/check_delete.inc.php");

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("category$__deep","id");

$theme->page_open_foot();
$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
