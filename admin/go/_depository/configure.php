<?php
/**
 * Magazyn
 * 
 * @author lech@sote.pl
 * @version $Id: configure.php,v 1.1 2005/11/18 15:31:22 lechu Exp $
 * @package    depository
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->configure_bar);

$error_message = '';
$ok_message = '';

$available_res = $mdbd->select("user_id,name", "available", "1=1", array(), "ORDER BY num_from", "array");


if (!empty($_REQUEST['form'])) {
    
    include_once("./include/configure.inc.php");
    /*
    if(empty($error_message)) {
        $ok_message = $lang->ok_message['intervals_changes'];
    }
    */
}
include_once("./html/configure.html.php");

$theme->page_open_foot();
$theme->foot();
include_once ("include/foot.inc");

?>