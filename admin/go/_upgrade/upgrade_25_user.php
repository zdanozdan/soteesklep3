<?php
/**
* Skrypt wywo³uj±cy aktualizacjê danych klientów z wersji 2.5->3.0
*
* @author  m@sote.pl
* @version $Id: upgrade_25_user.php,v 1.5 2005/01/20 14:59:43 maroslaw Exp $
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

$theme->bar($lang->upgrade_title);

require_once("include/ver2.5/upgrade_users.inc.php");
$upgrade_users =& new UpgradeUsers();
if ($upgrade_users->upgradeAll()) {
    print "<p />$lang->upgrade_done<p />\n";
    $buttons->button($lang->back,"index.php");
} else {
    print "<p />$lang->upgrade_25_done<p />\n";   
    $buttons->button($lang->back,"index.php");
}

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
