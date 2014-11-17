<?php
/**
* Zaณฑcz plik opisu i zapisz je w katalogu htdocs/products
*
* @author m@sote.pl
* @version $Id: edit_upload_desc.inc.php,v 2.4 2004/03/22 15:51:14 maroslaw Exp $
* @package admin
* @subpackage edit
*
* @global array $item dane z formularza
*
* @verified 2004-03-16 m@sote.pl
*/

$user_id=$item['user_id'];
$user_id=ereg_replace(" ","_",$user_id);
if (ereg("\.\.",$user_id)) {
    die ("Forbidden: $user_id not allowed");
}

if (! empty($_FILES['desc_file'])) {
    $file_tmp=$_FILES['desc_file']['tmp_name'];
    $file_name=$_FILES['desc_file']['name'];
    if (! empty($file_name)) {
        $ftp->connect();
        $ftp->put($file_tmp,$config->ftp_dir."/htdocs/products",$user_id.".html.php");
        $ftp->close();
    }
}

// usun opis, jesli wywolano przyscik usun
if (! empty($_POST['item_del'])) {
    $item_del=$_POST['item_del'];
    $ftp->connect();
    $ftp->delete($config->ftp_dir."/htdocs/products",$user_id.".html.php");
    $ftp->close();
}

?>