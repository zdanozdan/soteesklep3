<?php
/**
 * Aktualizuj edytowany plik html
 *
 * @author      m@sote.pl
 * \@modified_by piotrek@sote.pl
 * @version     $Id: edit_preview.php,v 2.6 2005/01/20 14:59:40 maroslaw Exp $
* @package    text
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");

if (! empty($_REQUEST['file'])) {
    $file=basename($_REQUEST['file']);
} 

if (($config->devel==1) && (! empty($_REQUEST['filedev']))) {
    $filedev=$_REQUEST['filedev'];
} else die  ("Forbidden");


#if (! empty($_REQUEST['file'])) {
#    $file=$_REQUEST['file'];
#} else {
#    die ("Bledne wywolanie");
#}
#
#if (! empty($_REQUEST['lang_name'])) {
#    $lang_name=$_REQUEST['lang_name'];
#} else {
#    die ("Bledne wywolanie");
#}
#

if (! empty($_REQUEST['update'])) {
    $update=$_REQUEST['update'];
} else $update=false;


// sprawdzaj tylko dla edycji textow, a nie dla edycji plikow devel
if (($config->devel!=1) && (! empty($filedev))) {
    // plik tekstowy
    if (! empty($_REQUEST['file_name'])) {
        $file_name=$_REQUEST['file_name'];
    } else {
        die ("Bledne wywolanie");
    }
    
    if (! empty($_REQUEST['lang_name'])) {
        $lang_name=$_REQUEST['lang_name'];
    } else {
        die ("Bledne wywolanie");
    }
  
    $file_dir="htdocs/themes/_$lang_name/_html_files"; // sciezka od glownego katalogu sklepu, dla ftp
    $file_path="$DOCUMENT_ROOT/../htdocs/themes/_$lang_name/_html_files/$file";
} else {
    // plik devel
    $file_name=$filedev;
    $file_dir=dirname($filedev);
    $file_path=$DOCUMENT_ROOT."/".$file_dir."/lang.inc.php";
}

#$file_dir="htdocs/themes/_$lang_name/_html_files"; // sciezka do glownego z plikami html dla odpow. jezyka, dla ftp
#$file_path="$DOCUMENT_ROOT/../htdocs/themes/_$lang_name/_html_files/$file";

$theme->head_window();

if ($update==true) {
    include_once("./include/update_file.inc.php");
}

$fd=fopen($file_path,"r");
$file_source=fread($fd,filesize($file_path));
fclose($fd);

include_once ("./html/edit_preview.html.php");

$theme->foot_window();

include_once ("include/foot.inc");
?>
