<?php
/**
 * Lista wszystkich produktow danego producenta
 * 
 * @param int $_REQUEST['id_producer']
 * 
 * @author m@sote.pl
 * @version $Id: producer.php,v 2.3 2005/01/20 14:59:18 maroslaw Exp $
* @package    category
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

if (ereg("^[0-9]+$",$_REQUEST['id_producer'])) {
    $id_producer=$_REQUEST['id_producer'];
} else die ("Forbidden");

// naglowek
$theme->head();

// zaznacz wszystkie produkty
$sql = "SELECT * FROM main WHERE id_producer=$id_producer";

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

$theme->page_open_head();
$dbedit = new DBEditList;
$dbedit->title=$lang->bar_title['category_all'];
$dbedit->start_list_element=$theme->list_th();

// wstaw liste sortowania tabeli main
include_once ("include/order_main.inc.php");

print "<form action=/go/_delete/index.php method=post name=FormList>";
$theme->menu_list();
$dbedit->show();
$theme->page_open_foot();
print "</form>";

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
