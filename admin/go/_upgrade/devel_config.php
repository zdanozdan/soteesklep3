<?php
/**
* Upgrade pakietu. Automatyczna aktualizacja programu.
* Strona z formularzem za³±czenia pakietu upgrade oraz odczytanie za³±czonego pliku.
*
* @author m@sote.pl
* @version $Id: devel_config.php,v 1.1 2005/04/15 06:59:46 maroslaw Exp $
* @package    upgrade
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

/**
* Dodaj obs³ugê sprawdzania wersji bazy danych i sklepu
*/
require_once ("./include/check_version.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->upgrade_title);

print "TODO: DEVEL config config/auto_config/patch_config.inc.php... not yet implemented";

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
