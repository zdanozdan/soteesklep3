<?php
/**
* Auto-naprawa plików zmodyfikowanych.
* Strona z formularzami zawieraj±cymi ¼ród³a plików z upgrade i z dysku.
*
* @author m@sote.pl
* @version $Id: repair.php,v 1.13 2005/05/09 10:26:24 maroslaw Exp $
* @package    upgrade
* @since 3.1
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

/**
* Dodaj obs³ugê sprawdzania wersji bazy danych i sklepu
*/
require_once ("./include/check_version.inc.php");

/**
* Biblioteka obs³ugi po³±czeñ GET/POST HTTP
*/
require_once ("HTTP/Client.php");

// odczytaj numer wersji aktualnego sklepu
$fd=fopen("../../../VERSION","r");
$version=trim(fread($fd,filesize("../../../VERSION")));
fclose($fd);

// naglowek
$theme->head_window();

// sprawd¼ czy jest odpowiednie repozytorium wersji
// sprawd¼ istneinie pliku np. http://www.sote.pl/upgrades/repoVersions/3.1pre5/soteesklep3/VERSION
$http =& new HTTP_Client();
$http->get("http://www.sote.pl/upgrades/repoVersions/$version/soteesklep3/VERSION");
if (! empty($http->_responses[0]['body'])) {
    $version_repo=trim($http->_responses[0]['body']);    
    
    if ($version!=$version_repo) {
                
        print $lang->upgrade_repo_not_exists;
        
        require_once ("Mail/MyMail.php");
        $mail =& new MyMail();
        $mail->send($config->order_email,$config->service_email,"Unknown repoVersion: $version, $config->www",'');
        
        $theme->foot_window();
        include_once ("include/foot.inc");
        exit;

    }
}

if ((! empty($_POST['file'])) && (empty($_POST['new']))) {
    $file=$_POST['file'];
    $file['path']=urldecode($file['path']);
    $file['upgrade']=urldecode($file['upgrade']);
    $file['patch_version']=intval($file['patch_version']);

    $theme->bar($lang->upgrade_diff_title."<br><b>".$file['name']."</b>");

    // znajd¼ ró¿nicê pomiêdzy plikami
    require_once ("HTTP/Client.php");
    $http =& new HTTP_Client();
    $http->post("http://www.sote.pl/plugins/_bugs/_diff/index_31.php",
    array("diff[file1]"=>$file['path'],"diff[file2]"=>$file['upgrade'],"diff[file_name]"=>$file['name'],"diff[version]"=>$version));

    $file['diff']='';
    if (! empty($http->_responses[0]['body'])) {
        $data=unserialize($http->_responses[0]['body']);
        $file['diff']=$data['diff'];
        $file['diff_result']=$data['diff_result'];
    }

    // zapisz znalezione ró¿nice po analizie plików
    $f_tmp=$DOCUMENT_ROOT."/tmp/upgrade_diff.txt";
    $fd=fopen($f_tmp,"w+");
    fwrite($fd,$data['diff_patch'],strlen($data['diff_patch']));
    fclose($fd);

    // ustal nazwê pliku, gdzie bêdize przetrzymywany tymczasowy plik do instalacji
    // nazwa pliku powinna byæ unikatowa, gdy¿ je¶li kilka osób dokonuje aktualizacji
    // mo¿e wyst±piæ problem zwui±zany z instalacj± innego pliku ni¿ naprawiany
    $fname=ereg_replace("/","_",$file['name']);
    $file['tmp_file']=$sess->id."-".$fname;

    $file_tmp=$DOCUMENT_ROOT."/tmp/".$file['tmp_file'];
    if ($fd=fopen($file_tmp,"w+")) {
        $res=fwrite($fd,$file['diff'],strlen($file['diff']));
        fclose($fd);
    } else {
        die ("Error: I can't create the file ".$file_tmp."<br />");
    }

    // zapisz $file['diff'] i $file['diff_result'] w plikach
    $file_tmp_diff_source=$DOCUMENT_ROOT."/tmp/diff_source_".$file['tmp_file'].".txt";
    $file_tmp_diff_result=$DOCUMENT_ROOT."/tmp/diff_result_".$file['tmp_file'].".txt";
    if ($fd=fopen($file_tmp_diff_source,"w+")) {
        fwrite($fd,$file['diff'],strlen($file['diff']));
        fclose($fd);
    }
    if ($fd=fopen($file_tmp_diff_result,"w+")) {
        fwrite($fd,$file['diff_result'],strlen($file['diff_result']));
        fclose($fd);
    }

    /**
    * Informacja HTML
    */
    include_once ("./html/repair.html.php");

} elseif (! empty($_POST['new'])) {
    if (! empty($_POST['file'])) {
        $file=$_POST['file'];
        $theme->bar($lang->upgrade_diff_title."<br><b>".$file['name']."</b>");
        $new=$_POST['new'];
        if (! empty($_POST['file']['tmp_file'])) {
            // plik tymczasowy z zawarto¶ci±, która ma byæ instalowana
            $new_file=$_POST['file']['tmp_file'];

            // nazwa pliku pakietu aktualizaycjnego
            $upgrade_file=$_POST['file']['upgrade_file'];

            // zrob kopie oryginalnego pliku
            // zapisz nowy plik w odpowiedniej lokalizacji
            // zapisz informacje (sumê kontroln±) o wstawieniu poprawionego pliku do pliku sum_diff.md5
            require_once ("./include/upgrade.inc.php");
            // require_once ("include/ftp.inc.php");

            // $ftp->connect();
            $upgrade =& new DiffUpgrade($upgrade_file);
            $file_name=preg_replace("/^soteesklep[0-9]\//","",$file['name']);
            $file_name=$file['name'];

            // odczytaj zawarto¶æ pliku i zapamiêtaj $new_file
            $file_tmp=$DOCUMENT_ROOT."/tmp/".$new_file;
            if ($fd=fopen($file_tmp,"r")) {
                $new_file=fread($fd,filesize($file_tmp));
                fclose($fd);
            } else die ("I can't open the file $file_tmp <br />");

            // if ($upgrade->upgradeFile($file_name,$new_file,UPGRADE_FILE_MOD,UPGRADE_SAVE_MOD)) {
            print "<p />\n";
            print $lang->upgrade_diff_file_upgraded;
            //print "<b>".$upgrade->getLastFileCopyName();
            //print "</b><br />\n";
            print "<li>$file_name</li>\n";

            // zapisz po³±czony plik w bazie
            $upgrade->saveModFile($file_name,$new_file,$file['patch_version']);

            print "<center>";
            print "<form><input type=button value=\"$lang->close\" onclick=\"window.close();\"></form>\n";
            print "</center>";

            /*
            // zapisanie sumy kontrolnej do pliku mod.md5
            require_once("include/file_checksum.inc.php");
            $file_name_1=preg_replace("/^soteesklep3\//","",$file_name);
            $file_name_2=preg_replace("/^soteesklep3/",".",$file_name);

            $file_root_path=$DOCUMENT_ROOT."/../".$file_name_1;

            // print "file_name_1=$file_name_1 <br>";
            // print "file_name_2=$file_name_2 <br>";
            // print "file_root_path = $file_root_path <br>";


            $fc =& new FileChecksum($file_root_path,FILE_CHECKSUM_FILE,"mod.md5");
            // odczytaj sumê kontroln± pliku z dysku
            $file_checksum=$fc->getChecksum();
            // print "file_checksum pliku instalowanego=$file_checksum <br>";
            $fc->set($file_name_2,$file_checksum);
            $fc->saveDAT();
            */
            // }
            // $ftp->close();
        }
    } else {
        $theme->bar($lang->upgrade_diff_title);
        print $lang->upgrade_file_not_found;
    }
} else {
    $theme->bar($lang->upgrade_diff_title);
    print $lang->upgrade_file_not_found;
}

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>