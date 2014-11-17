<?php
/**
* Odczytaj zalaczone zdjecie
*
* @author  m@sote.pl
* @version $Id: file.inc.php,v 1.3 2004/12/20 18:00:45 maroslaw Exp $
* @package    promotions
*/

// zalacz zdjecie
if (! empty($_FILES['item']['name']['photo'])) {
    $file=$_FILES['item'];
    $datafile=$file['name']['photo'];
    $datafile_tmp=$file['tmp_name']['photo'];
    $_POST['item']['photo']=$datafile;
    $ftp->connect();    
    $ftp->put($datafile_tmp,"$config->ftp_dir/htdocs/photo/_promotions",$datafile);
    $ftp->close();
} elseif (! empty($_POST['item']['photo2'])) {
    $_POST['item']['photo']=$_POST['item']['photo2'];
}

?>
