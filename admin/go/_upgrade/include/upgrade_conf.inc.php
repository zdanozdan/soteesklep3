<?php
/**
* @package    upgrade
*/
/*
* Sprawd¼ czy istnieje plik ./admin/upgrade/nazwa_pakietu.conf.
* Je¶li plik istnieje to odczytaj zdjêcia zawarte w pliku i ¶ci±gnij je z z sote.pl/upgrades/repo_gid
* i zainstaluj w odpowiednim katalogu w sklepie
* (w pakiety .pkg nie zawieraj± plików binarnych, dlatego pliki takie s± ¶ci¿gane z WWW podczas instalacji)
*
* @author  m@sote.pl
* @version $id$
* @package upgrade
*
* \@global string $upgrade_pkg numer wersji pakietu np. 30016
* \@global string $file        nazwa pliku zawieraj±cego np. /home/path/soteesklep3/admin/upgrade/upgrade_1234_30016.pkg
*/

/**
* Dodaj obs³ugê FTP
*/
require_once ("include/ftp.inc.php");

/**
* Obs³uga po³±czeñ HTTP
*/
require_once ("HTTP/Client.php");

$file_name_1=substr($file,0,strlen($file)-3);
$file_name_conf=basename($file_name_1."conf"); // np. upgrade_argt_30016.conf
$file_name_conf_path="$DOCUMENT_ROOT/upgrade/$file_name_conf";

if (file_exists($file_name_conf_path)) {
    if ($fd=fopen($file_name_conf_path,"r")) {
        $data=fread($fd,filesize($file_name_conf_path));
        fclose($fd);
        $tab=split("\n",$data);
        $tab1=split(":",$tab[0],2);
        if (! empty($tab1[1])) {
            $gid=$tab1[1];
            unset($tab[0]);
            reset($tab);
            $ftp->connect();
            foreach ($tab as $file) {
                if (! empty($file)) {
                    
                    $file_basename=basename($file);
                    $file_dir=dirname($file);$file_dir=preg_replace("/^\./","",$file_dir);
                    $file_tmp=$DOCUMENT_ROOT."/tmp/$file_basename";
                    
                    // pobierz plik i zapisz go  w ./admin/tmp
                    $http =& new HTTP_Client();
                    
                    $http->get("http://www.sote.pl/upgrades/repo_gid/modifications_gid_$gid/soteesklep3/$file");
                    $data=$http->_responses[0]['body'];
                    
                    if ($fd=fopen($file_tmp,"w+")) {
                        fwrite($fd,$data,strlen($data));
                        fclose($fd);
                        // instaluj plik w docelowej lokalizacji
                        
                        $ftp->put($file_tmp,$config->ftp['ftp_dir'].$file_dir,$file_basename);
                        unlink($file_tmp);
                    }
                    
                }
            } // end foreach
            $ftp->close();
        } else print $lang->upgrade_unknown_gid;
    }
    
}
?>
