<?php
/**
* @version    $Id: edit.php,v 1.7 2005/01/20 14:59:44 maroslaw Exp $
* @package    wysiwyg
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
global $config;
require_once ("../../../include/head.inc");

require_once ("WYSIWYG/wysiwyg.inc.php");
$file = $_REQUEST['file'];
$chosen_lang = $_REQUEST['chosen_lang'];
$filename = $file;

$file = $DOCUMENT_ROOT . "/../htdocs/themes/_" . $chosen_lang . "/_html_files/" . $file;
if(is_file($file))
{

	if ($file_handle = @fopen($file, "r")) {
    	$contents = @fread($file_handle, filesize($file));
	    fclose($file_handle);
	}
	$wysiwyg =& new Wysiwyg($config->lang);
	$wysiwyg->Editor($contents, 'html_out',"edit_post.php?chosen_lang=$chosen_lang&filename=" . $filename);
}
else
	echo "Brak takiego pliku $file";
include_once ("include/foot.inc");
?>
