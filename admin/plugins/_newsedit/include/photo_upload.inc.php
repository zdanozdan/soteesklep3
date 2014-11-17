<?php
/**
* Za³aduj zdjecia (je¶li zostaly zalaczone z formularza)
*
* \@global int $global_id
*
* @author m@sote.pl
* @version $Id: photo_upload.inc.php,v 2.3 2004/12/20 18:00:11 maroslaw Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

if ($global_secure_test!=true) die ("Forbidden");

$dir="$config->ftp_dir/htdocs/plugins/_newsedit/news/".$global_id;

// zaloz katalog $dir
$ftp->mkdir($dir);

for ($i=1;$i<=8;$i++) {
    $filename="photo$i";
    if (! empty($_FILES['newsedit']['name'][@$filename])) {
        $datafile=$_FILES['newsedit']['name'][@$filename];
        $datafile_tmp=$_FILES['newsedit']['tmp_name'][@$filename];
        $ftp->put($datafile_tmp,"$dir",$datafile);
        $rec->data[$filename]=$datafile;
    } // end if
} // end for

$filename="photo_small";
if (! empty($_FILES['newsedit']['name'][@$filename])) {
    $datafile=$_FILES['newsedit']['name'][@$filename];
    $datafile_tmp=$_FILES['newsedit']['tmp_name'][@$filename];
    $ftp->put($datafile_tmp,"$dir",$datafile);
    $rec->data[$filename]=$datafile;
} // end if

?>
