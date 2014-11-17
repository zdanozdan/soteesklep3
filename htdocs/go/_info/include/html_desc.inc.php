<?php
/**
 * Wyswietl pelny opis zalaczony z pliku HTML
 *
 * @author piotrek@sote.pl
 * @version $Id: html_desc.inc.php,v 2.8 2004/06/30 10:00:01 maroslaw Exp $ 
 * @package soteesklep info 
 */

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($secure_test)) || (! empty($_REQUEST['secure_test']))) {
    die ("Forbidden");
}

$file=$rec->data['user_id'];
$file=ereg_replace(" ","_",$file);
$file.=".html.php";

$file_path="$DOCUMENT_ROOT/products/$file";
if ($fd=@fopen($file_path,"r")) {
    $desc=fread($fd,filesize($file_path));
    print $desc;
    fclose($fd);
}

?>