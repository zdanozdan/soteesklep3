<?php
/**
 * Usun zaznaczone waluty
 *
 * @author m@sote.pl
 * @version $Id: delete.php,v 1.3 2005/01/20 14:59:32 maroslaw Exp $
 * @package currency
 */

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->delivery_zone_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("delivery_zone","id");


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
