<?php
/**
* Aktualizacja danych z wersji 2.5 -> 3.0
*
* @author  m@sote.pl
* @version $Id: upgrade25_30.php,v 1.3 2005/01/20 14:59:42 maroslaw Exp $
* @package    upgrade
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->upgrade_title);

print "<p />\n";
print "Upgrade 2.5->3.0";

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
