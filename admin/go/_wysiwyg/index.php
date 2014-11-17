<?php
/**
* @version    $Id: index.php,v 1.7 2005/01/20 14:59:44 maroslaw Exp $
* @package    wysiwyg
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once("config/config.inc.php");

/*
print "<pre>";
print_r($config->wysiwyg_files);
print "</pre>";
*/

include_once ("./include/menu.inc.php"); // menu 
$theme->bar($lang->wysiwyg_bar);            // bar 


$chosen_lang = @$_REQUEST['chosen_lang'];
if(empty($chosen_lang))
	$chosen_lang = $config->lang;
include("filelist.html.php");

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
