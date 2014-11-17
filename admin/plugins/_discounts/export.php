<?php
/**
 *
 * Eksportowanie danych z tabeli discounts do pliku config/tmp/discounts.inc.php
 *
 * @author pm@sote.pl
 * \@template_version Id: index.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: export.php,v 2.3 2005/01/20 14:59:49 maroslaw Exp $
* @package    discounts
 */

$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

$theme->head();
$theme->page_open_head();
include("include/menu.inc.php");

$theme->bar($lang->discounts_export_bar);

// eksportuj dane z tabli discounts do pliku
include_once("./include/export.inc.php");

$theme->page_open_foot();
// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
