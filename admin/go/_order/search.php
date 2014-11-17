<?php
/**
* Wywo³anie formularza wyszukiwania transkacji.
*
* @author  m@sote.pl
* @version $Id: search.php,v 2.7 2005/01/20 14:59:35 maroslaw Exp $
* @package    order
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
require_once ("include/date.inc.php");
require_once ("./include/search_fun.inc.php");
require_once ("./include/order_func.inc.php");   

$my_date =& new DateFormElements;

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->bar_title['order_search']);

print "<form action=search2.php method=get>\n";
include_once ("./html/search.html.php");
print "</form>\n";

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
