<?php
/**
* Edycja danych produktu, zwi±zanych z indeksowaniem m.in. w googlach.
*
* @author  m@sote.pl
* @vresion $Id: google.php,v 2.3 2005/01/20 14:59:21 maroslaw Exp $
* @version    $Id: google.php,v 2.3 2005/01/20 14:59:21 maroslaw Exp $
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
    $mdbd->update("main","google_title=?, google_keywords=?, google_description=?","id=?",
    array("1,".@$item['title']=>"text",
          "2,".@$item['keywords']=>"text",
          "3,".@$item['description']=>"text",
          "4,".$id=>"int"));    
} else {
    // odczytaj dane zapisane w bazie (warto¶ci domy¶lne przy wywo³aniu formularza)
    $dat=$mdbd->select("google_title,google_keywords,google_description","main","id=?",array($id=>"int"),"LIMIT 1");
    $__item['title']=$dat['google_title'];
    $__item['keywords']=$dat['google_keywords'];
    $__item['description']=$dat['google_description'];
}

$theme->head_window();
include_once ("./include/menu.inc.php");
$theme->bar($lang->edit_google_title);

// wyswietl formularz
include_once ("./html/google.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>
