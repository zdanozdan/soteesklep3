<?php
/**
* Pobierz plik z lokalizacji wskazanej w tabeli main_keys_ftp wg kodu
*
* @author  m@sote.pl
* @version $Id: download.php,v 1.3 2005/01/20 15:00:26 maroslaw Exp $
* @package    main_keys
*/

// sprawd¼ jakie rozsze¿enie ma pobierany plik i w zale¿no¶ci od tyypu ustaw odpowiedni typ nag³ówka
if (ereg(".mp3?",$_SERVER['REQUEST_URI'])) {
    header("Content-type: audio/mpeg");
} else {
    header("Content-type: application");
}

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

if (! empty($_REQUEST['code'])) {
    $code=addslashes($_REQUEST['code']);
} else {
    $theme->go2main();
    exit;
}

// opdczytaj nazwe pliku
$user_id=$mdbd->select("user_id_main","main_keys","main_key_md5=?",array($code=>"text"),"LIMIT 1");
if (empty($user_id)) {
    // sprawdz czy produkt oznaczony parametrem jako "demo", jest w bazie takze oznaczony jako"demo"
    $dat=split("_",$code,2);
    if (@$dat[0]=="demo") {
        if ((@ereg("^[0-9]+$",@$dat[1])) && ($dat[1]>0)) {
            $id=$dat[1];
            $user_id=$mdbd->select("user_id_main","main_keys_ftp","id=? AND demo=1 AND active=1",array($id=>"int"),"LIMIT 1");
        }
    }
}

if (empty($user_id)) {
    $theme->go2main();
    exit;
}

$file=$mdbd->select("ftp","main_keys_ftp","user_id_main=? AND active=1",array($user_id=>"text"),"LIMIT 1");
$dest_file="$DOCUMENT_ROOT/../download/$file";
if (file_exists($dest_file)) {

    $handle = fopen($dest_file, "rb");
    $contents = '';
    while (!feof($handle)) {
        $contents .= fread($handle, 8192);
    }
    fclose($handle);   
    print $contents;
    exit;
    
} else {
    $theme->head();
    $theme->page_open_head("page_open_1_head");
    $theme->go2main(8);
    $theme->bar($lang->main_keys_download_title);
    print "<p>";
    print $lang->main_keys_download_not_found;
    $theme->page_open_head("page_open_1_foot");
    $theme->foot();
    exit;
}
exit;
?>
