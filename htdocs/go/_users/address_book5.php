<?php
/**
 * Ksiazka adresowa zalogowanego uzytkownika
 * 
 * @author  m@sote.pl
 * @version $Id: address_book5.php,v 1.4 2005/01/20 15:00:22 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
if(empty($__open_head)){
  //$theme->head();
  $theme->page_open_head("page_open_1_head");
}

include_once("./include/menu.inc.php"); 
if(@$__bar!=true){
	$theme->bar($lang->bar_title['address_book']);    
}
require_once("./include/address_book.inc.php");
$address_book=new AddressBook;
$address_book->deleteRecord();

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
