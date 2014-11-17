<?php
/**
 * Aktualizacja grup rabatowych - automatyczne przyporzadkowanie klientow do danej grupy rabatowej na podstawie ich obrotow
 * 
 * @author p@sote.pl
 * @version $Id: update_dg.php,v 1.3 2005/01/20 14:59:51 maroslaw Exp $
* @package    discounts
* @subpackage discounts_groups
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

require_once ("./include/update_dg.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();
include("include/menu.inc.php");

$theme->bar($lang->discounts_groups_update_bar);

$update_dg = new UpdateDG;   // inicjacja obiektu 
   
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");

?>
