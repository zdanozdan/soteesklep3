<?php
/**
 * Terminarz zalogowanego uzytkownika
 * 
 * @author  rp@sote.pl
 * @version $Id: reminder.php,v 1.7 2005/10/28 06:34:11 lechu Exp $
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
$theme->bar($lang->bar_title['reminder']);  

if(@$_REQUEST['del']==true){
    $__bar=true;
    $__open_head=true;
    require_once("reminder5.php");
    exit;
}
else if(@$_REQUEST['edit']==true){
    $__bar=true;
    $__open_head=true;
    require_once("reminder1.php");
    exit;
} else {
    $user_reminder->addUrl();
    $theme->theme_file("_users/reminder/reminder.html.php");
}

$theme->page_open_foot("page_open_1_foot");
$sql = $user_reminder->_selectToRemindSQL(time());
$user_reminder->_getRecordsToRemind($sql);

echo "<pre>";
print_r($user_reminder->records);
echo "</pre>";
// stopka
$theme->theme_file("products4u.html.php");

$theme->foot();
include_once ("include/foot.inc");
?>
