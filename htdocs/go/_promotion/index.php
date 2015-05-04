<?php
/**
* Produkty w promocji nowo¶ci itp. wg kolumny $_REQUEST['column']
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.4 2005/01/20 15:00:18 maroslaw Exp $
* @package    promotion
*/
$global_database=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

$column="";
if (! empty($_REQUEST["column"])) {
    $column=$_REQUEST['column'];
}

// sprawdz czy przekazano poprawna kolumne
if (($column!="promotion") && ($column!="newcol") && ($column!="bestseller") && ($column!="main_page")) {
    die ("Forbidden: \$column");
}

// usun ; (na wszelki wypadek - podwojne zabezpieczenie)
$column=ereg_replace(";","\;",$column);

// naglowek
$theme->head();

// zapytamie o produkty w promocji, nowowsci itp
$sql = "SELECT * FROM main WHERE $column='1'";
$result=$db->Query($sql);
if ($result==0) {
    $db->Error();
}

// funkcja prezentujaca wynik zapytania w glownym oknie strony
include_once ("include/dbedit_list.inc");
$dbedit = new DBEditList;
$dbedit->title=$lang->bar_title[$column];
$theme->page_open_object("show",$dbedit,"page_open");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
