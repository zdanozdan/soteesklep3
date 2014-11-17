<?php
/**
* @version    $Id: edit_post.php,v 1.6 2005/01/20 14:59:44 maroslaw Exp $
* @package    wysiwyg
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");
include_once("./config/config.inc.php");
require_once ("HTML/Parser/parserHTML.php");
?>
<table width="100%" height="100%">
<tr>
<td width="100%" height="100%" align="center" valign="middle">
<?PHP
$filename = $_REQUEST['filename'];
$chosen_lang = $_REQUEST['chosen_lang'];
$editing = @$_REQUEST['editing'];
if($editing == 'classic')
	$html_out = $_REQUEST['html_out'];
else{
    $htmlParser = & new ParserHTML;
    $html_out = $htmlParser->parse($_REQUEST['html_out']);
//	$html_out = str_replace('>', ">\n", $_REQUEST['html_out']);
}
// 1. zapisujemy plik w katalogu tymczasowym $local=$DOCUMENT_ROOT/tmp/costam.html 
// 2. ftpujemy ten plik do docelowej lokalizxacji
$local=$DOCUMENT_ROOT . "/tmp/" . $filename;


if (!$handle = fopen($local, 'w')) {
	echo "Nie mo¿na utworzyæ pliku ($local)";
	exit;
}

// Write $somecontent to our opened file.
if (fwrite($handle, $html_out) === FALSE) {
	echo "Nie mo¿na pisaæ do pliku ($local)";
	exit;
}


fclose($handle);

$remote_dir=$config->ftp['ftp_dir']."/htdocs/themes/_".$chosen_lang."/_html_files";
$ftp->connect();
$ftp->put($local,$remote_dir,$filename);
$ftp->close();

echo "<script>window.close()</script>";
?>
</td>
</tr>
</table>
<?PHP
include_once ("include/foot.inc");
?>
