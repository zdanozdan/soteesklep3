<?php
/**
* @version    $Id: edit_classic.php,v 1.3 2005/01/20 14:59:44 maroslaw Exp $
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

	$file_handle = fopen($file, "r");
	$contents = fread($file_handle, filesize($file));
	fclose($file_handle);
	?>
	Edycja tekstu:<br>
	<form action="edit_post.php?chosen_lang=<?php echo $chosen_lang ?>&filename=<?php echo $filename ?>&editing=classic" method="POST">
	<TEXTAREA name=html_out style="width: 100%; height: 80%;"><?php echo $contents?></TEXTAREA>
	<INPUT type="submit" value="Zatwierd¼">
	</form>
	<?php
}
else
	echo "Brak takiego pliku $file";
include_once ("include/foot.inc");
?>
