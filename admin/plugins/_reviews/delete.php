<?php
/**
 * PHP Template:
 * Usun rekordy z tabeli reviews
 * 
 * @author m@sote.pl
 * \@template_version Id: delete.php,v 2.1 2003/03/13 11:28:48 maroslaw Exp
 * @version $Id: delete.php,v 1.4 2005/01/20 15:00:08 maroslaw Exp $
* @package    reviews
 */

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php


// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->reviews_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("reviews","id");

//# zapisz wartosci tablicy w pliku configuracyjnym 
// include_once ("./include/user_config.inc.php"); 

$theme->page_open_foot();

$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
