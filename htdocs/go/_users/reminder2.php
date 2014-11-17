<?php
/**
 * Ksiazka adresowa zalogowanego uzytkownika (potwierdzenie wprowadzonych danych)
 * 
 * \@global bool $__bar zalaczanie naglowka 
 *
 * @author  m@sote.pl
 * @version $Id: reminder2.php,v 1.4 2005/01/20 15:00:25 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true;

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");
if(!empty($_REQUEST['reminder'])) $data=$_REQUEST['reminder']; 
else {
    $theme->go2main();
    exit;
}

require_once("./include/reminder.inc.php");
$user_reminder=new UserReminder;
$theme->user_reminder=&$user_reminder;

// naglowek
if(empty($__open_head)){
  $theme->head();
  $theme->page_open_head("page_open_1_head");
}

// przyciski
include_once("./include/menu.inc.php"); 
if(@$__bar!=true){
	$theme->bar($lang->bar_title['reminder']);    
}
// zawartosc strony

$user_reminder->insertData($data);

// stopka
$theme->page_open_foot("page_open_1_foot");
$theme->foot();
include_once ("include/foot.inc");
?>
