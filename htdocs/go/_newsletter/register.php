<?php
/**
 * Dodaj usun uzytkownika do newsletter
 *
 * @author  m@sote.pl
 * @version $Id: register.php,v 2.5 2005/01/20 15:00:18 maroslaw Exp $
* @package    newsletter
 */

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
include_once("include/metabase.inc");

// naglowek
$theme->head();
$theme->theme_file("page_open_1_head.html.php");

$theme->bar($lang->newsletter_title);

if (! empty($_REQUEST['email'])) {
    $email=$_REQUEST['email'];
    $email=addslashes($email);
} else $email='';

if (! empty($_REQUEST['act'])) {
    $action=$_REQUEST['act'];        
} else $action='';

if($action == 'del') {
    $database->sql_update("newsletter","md5=$email",array("status"=>"0","active"=>"0"));
    print $lang->newsletter_delete;
} elseif($action == 'add') {
    $database->sql_update("newsletter","md5=$email",array("status"=>"1","active"=>"1"));
    print $lang->newsletter_confirm;
} else {
    print $lang->newsletter_error;
}

$theme->theme_file("page_open_1_foot.html.php");
// stopka

$theme->foot();
include_once ("include/foot.inc");
?>
