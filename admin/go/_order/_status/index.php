<?php
/**
*  Lista statusów transakcji.
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.6 2005/01/20 14:59:36 maroslaw Exp $
* @package    order
* @subpackage status
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("../lang/_$config->lang/lang.inc.php");
include_once ("../include/menu_top.inc.php");

include_once ("./include/menu.inc.php");
$theme->bar($lang->order_status_bar);

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/order_status_row.inc.php");
$dbedit = new DBEditList;
$sql="SELECT * FROM order_status ORDER BY user_id";
$dbedit->top_links="true";
$dbedit->record_class="order_statusRow";

print "<p>";

require_once ("./include/list_th.inc.php");
$dbedit->start_list_element=order_status_list_th();

print "<form action=delete.php method=post name=FormList>";
$dbedit->show();
print "</form>";
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
