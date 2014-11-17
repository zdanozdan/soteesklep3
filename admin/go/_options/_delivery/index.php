<?php
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
// $Id: index.php,v 2.4 2005/01/20 14:59:31 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();


print "<form action=delete.php method=post name=FormList>";
include_once ("./include/menu.inc.php");
$theme->bar($lang->delivery_bar);

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/delivery_row.inc.php");
$dbedit = new DBEditList;
$sql="SELECT * FROM delivery ORDER BY order_by";
$dbedit->top_links="false";
$dbedit->record_class="DeliveryRow";
print "<p>";

include_once ("./include/list_th.inc.php");
$dbedit->start_list_element=delivery_list_th();

$dbedit->show();
$theme->page_open_foot();
print "</form>";

  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
