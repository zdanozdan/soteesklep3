<?php
/**
 * Ksiazka adresowa zalogowanego uzytkownika
 * 
 * @author  rp@sote.pl
 * @version $Id: address_book.php,v 1.10 2005/10/28 06:33:49 lechu Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");


// naglowek
if(empty($__open_head)){
  $theme->head();
  $theme->page_open_head("page_open_1_head");
}

include_once("./include/menu.inc.php"); 
$theme->bar($lang->bar_title['address_book']);  

require_once("./include/address_book.inc.php");
$address_book=new AddressBook;
$theme->address_book=&$address_book;
$address_book->maxRecord();    

if(@$_REQUEST['del']==true){
    $__bar=true;
    $__open_head=true;
    require_once("address_book5.php");
    exit;
} else {    
    $theme->theme_file("_users/address_book/address_book.html.php");
}

$theme->theme_file("products4u.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
