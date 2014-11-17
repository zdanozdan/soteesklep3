<?php
/**
 * Eksportowanie danych z tabeli dictionary do pliku config/autoconfig/dictionary.inc.php
 *
 * @author piotrek@sote.pl
 * @version $Id: export.php,v 2.6 2005/01/20 14:59:47 maroslaw Exp $
* @package    dictionary
 */

$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// eksportuj dane z tabli discounts do pliku
include_once("./include/export.inc.php");

$theme->head();
$theme->page_open_head();
include("include/menu.inc.php");

$theme->bar($lang->dictionary_export_bar);
print $__status;

$theme->page_open_foot();
// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
