<?php
/**
* Definiowanie dodatkowych kategorii dla produktu (1 produkt w kilku kategoriach).
*
* @author  m@sote.pl
* @vresion $Id: category.php,v 2.4 2005/01/20 14:59:19 maroslaw Exp $
* @version    $Id: category.php,v 2.4 2005/01/20 14:59:19 maroslaw Exp $
* @package    edit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];   
    $__id=&$id;
} else die ("Forbidden: unknown ID");

if (! empty($_REQUEST['item'])) {
    // aktualizuj dane w bazie
    $item=$_REQUEST['item'];
    $__item=&$item;
    
    require_once ("include/category/main_category.inc");        
    $id_category_multi_1=MainCategory::getIDCategory($item['category_multi_1']);
    $id_category_multi_2=MainCategory::getIDCategory($item['category_multi_2']);
    
    $mdbd->update("main","category_multi_1=?, category_multi_2=?, id_category_multi_1=?, id_category_multi_2=?","id=?",
    array("1,".@$item['category_multi_1']=>"text",
          "2,".@$item['category_multi_2']=>"text",
          "3,".@$id_category_multi_1=>"text",
          "4,".@$id_category_multi_2=>"text",          
          "5,".$id=>"int"));    
} else {
    // odczytaj dane zapisane w bazie (warto¶ci domy¶lne przy wywo³aniu formularza)
    $dat=$mdbd->select("category_multi_1,category_multi_2","main","id=?",array($id=>"int"),"LIMIT 1");
    $__item['category_multi_1']=$dat['category_multi_1'];
    $__item['category_multi_2']=$dat['category_multi_2'];    
}

$theme->head_window();
include_once ("./include/menu.inc.php");
$theme->bar($lang->edit_category_title);

// wyswietl formularz
include_once ("./html/category.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>
