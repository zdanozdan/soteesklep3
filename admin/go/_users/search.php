<?php
/**
* @version    $Id: search.php,v 2.4 2005/01/20 14:59:43 maroslaw Exp $
* @package    users
*/
// +----------------------------------------------------------------------+
// | SOTEeSKLEP version 2                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1999-2002 SOTE www.sote.pl                             |
// +----------------------------------------------------------------------+
// | Zarzadzanie kosztami dostawy                                         |
// +----------------------------------------------------------------------+
// | authors:     Marek Jakubowicz <m@sote.pl> (base system)              |
// +----------------------------------------------------------------------+
//
// $Id: search.php,v 2.4 2005/01/20 14:59:43 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/date.inc.php");

$my_date = new DateFormElements;

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->bar_title['users_search']);

print "<form action=search2.php method=post>\n";
include_once ("./html/users_search.html.php");
print "</form>\n";

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
