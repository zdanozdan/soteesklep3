<?php
/**
 * PHP base project
 * 
 * Przykladowa konstrukcja schematu projektu opartego na PHP&PEAR
 * 
* @version    $Id: index.php,v 2.9 2005/03/30 06:50:25 krzys Exp $
* @package    category
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

// naglowek
$theme->head();

// odczytaj id wybranych kategorii i podkategorii
$idc="";
if (! empty($_REQUEST['idc'])) {
    $idc=$_REQUEST['idc'];
} 
$cidc="";
if (! empty($_REQUEST['cidc'])) {
    $idc=$_REQUEST['cidc'];
}  

// usun znaki " z wywolanie np. z wywolania idc="id_18" wygeneruj id_18
// znaki " w parametrach sa wymagane przez Treeview
$idc=ereg_replace("\"","",$idc);

if ((empty($idc)) && (! empty($cidc))) {
    $idc=$cidc;
}

// odczytaj id filtru producenta
if (ereg("^[0-9]+$",@$_REQUEST['producer_filter'])) {
   $producer_id=$_REQUEST['producer_filter'];
} elseif (ereg("^[0-9]+$",@$_SESSION['__producer_filter'])) {
   $producer_id=$_SESSION['__producer_filter'];
} else $producer_id=0;


// odczytaj id producenta
if (ereg("^[0-9]+$",@$_REQUEST['producer_id'])) {
    $producer_id=$_REQUEST['producer_id'];
}
if (! ereg("^[0-9]+$",$producer_id)) {
    $producer_id=0;
}

$__producer_filter=@$producer_id;
$sess->register("__producer_filter",$__producer_filter);

// zapamietaj parametr przekazany jako GET
$__get_idc=$idc;


// sprawdz czy wybrano koncowa kategorie (element menu), czy element bedacy submenu
$sub_menu_prefix=substr($idc,0,2);
if ($sub_menu_prefix=="id") {
    $sub_menu=true;    
    $idc=substr($idc,3,strlen($idc)-3);
} else {
    $sub_menu=false;
}

// rozdziel elementy (id) kategorii
$tab_idc=split("_",$idc,5);
$size_tab_idc=sizeof($tab_idc);

// generuj tablice array("1"=>"2","2"=>"3",...)
// id_category1=2 id_category2=3, ...
$category_tab=array();
for ($i=0; $i<$size_tab_idc; $i++) {
    $ic=$i+1;
    $category_tab[$ic]=$tab_idc[$i];
}

// generuj zapytanie SQL na podstawie przekazanych kategorii
require_once ("include/gen_sql.inc.php");
$sql = $category_sql->query($category_tab,$producer_id);

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

$theme->page_open_head();
$dbedit = new DBEditList;
$dbedit->title=$lang->products_from_category;
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
