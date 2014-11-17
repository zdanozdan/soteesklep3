<?php
/**
 * Eksport atrybutow do pliku js 
 * 
 * @author  piotrek@sote.pl
 * @version $Id: export.php,v 1.6 2005/01/20 14:59:27 maroslaw Exp $
* @package    offline
* @subpackage attributes
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

require_once("./include/export.inc.php");
$attributes = new ExportAttributes;

// naglowek
$theme->head();
$theme->page_open_head();
include("include/menu.inc.php");

$theme->bar($lang->attributes_export);

$attributes->attr2Main();
print "<BR><center>".$lang->attributes_export_ok."</center>";

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");

?>
