<?php
/**
 * Terminarz zalogowanego uzytkownika
 * 
 * @author  m@sote.pl
 * @version $Id: reminder5.php,v 1.4 2005/01/20 15:00:26 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

require_once("./include/reminder.inc.php");
$user_reminder=new UserReminder;
$theme->user_reminder=&$user_reminder;

// naglowek
if(empty($__open_head)){
  $theme->head();
  $theme->page_open_head("page_open_1_head");
}

include_once("./include/menu.inc.php"); 
if(@$__bar!=true){
	$theme->bar($lang->bar_title['reminder']);    
}

$user_reminder->deleteRecord();

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
