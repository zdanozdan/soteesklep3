<?php
/**
 * Za³±cz tre¶æ newsa w postaci pliku html.
 *  
 * \@global int $global_id
 *
 * @author m@sote.pl
 * @version $Id: html_upload.inc.php,v 2.3 2004/12/20 18:00:10 maroslaw Exp $
 *
 * \@verified 2004-03-19 m@sote.pl
* @package    newsedit
 */

if ($global_secure_test!=true) die ("Forbidden");

$dir="$config->ftp_dir/htdocs/plugins/_newsedit/news/".$global_id;

// zaloz katalog $dir
$ftp->mkdir($dir);  

$filename="desc_file";
if (! empty($_FILES['newsedit']['name'][@$filename])) {
    $datafile="news.html";
    $datafile_tmp=$_FILES['newsedit']['tmp_name'][@$filename];
    $ftp->put($datafile_tmp,"$dir",$datafile);
    $rec->data[$filename]=$datafile;
} // end if	

?>
