<?php
/**
* @version    $Id: index.php,v 2.5 2005/01/20 14:59:29 maroslaw Exp $
* @package    options
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
// $Id: index.php,v 2.5 2005/01/20 14:59:29 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();


print "<form action=delete.php method=post name=FormList>";
include_once ("./include/menu.inc.php");
$theme->bar($lang->options_title);

include_once ("./html/main.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
