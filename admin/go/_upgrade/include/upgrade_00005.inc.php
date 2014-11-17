<?php
/**
* Sprawd� czy wcze�niej nie instalowano uaktualnienia 00005 (uaktualnienie syetemu upgrade'u).
* Je�li tak, to dodaj uaktualnienie listy plik�w i sum kontolnych znajduj�cych si� w pliku
* ./upgrade_00005.md5. Dzi�ki temu uzupe�nimy dane, kt�rych nie zapisywa� systemu upgradeu przez
* aktualizacj� tego systemu.
*
* @author  m@sote.pl
* @version $Id: upgrade_00005.inc.php,v 1.3 2004/12/20 17:59:12 maroslaw Exp $
* @package    upgrade
*/

/**
* Obs�uga sum kontrolnych plik�w
*/
require_once ("include/file_checksum.inc.php");
$file_md5="$DOCUMENT_ROOT/go/_upgrade/upgrade_00005.md5";

if ($fd=fopen($file_md5,"r")) {
    $upgrade_sum_md5=fread($fd,filesize($file_md5));
    fclose($fd);
    
    $ftp->connect();
    $lines=split("\n",$upgrade_sum_md5);
    reset($lines);
    foreach ($lines as $line) {
        $tab=split(" ",$line,2);
        if (! empty($tab[1])) {
            $sum=trim($tab[0]);
            $file=trim($tab[1]);
            $file=substr($file,1,strlen($file)-1);            
            //$file="./admin/go/_upgrade".$file;                        
            $fc =& new FileChecksum($file,FILE_CHECKSUM_SOURCE);
            $fc->set(trim($file),$sum);
        }
    } // end foreach
    
    // zapisz now� baz� sum kontrolnych
    if (FileChecksum::saveDat()) {
        print "<p>$lang->upgrade_checksums_upgraded <p>";
    } else {
        print "<p><font color=\"red\">$lang->upgrade_checksums_upgrade_error</font><p>\n";
    }
    
    // usu� plik upgrade_00005.md5 z sumami kontrolnymi, gdy� zosta�y one przeniesione do g��wnego sum.md5
    require_once("include/ftp.inc.php");
    $file="/admin/go/_upgrade/upgrade_00005.md5";
    
    $dir_name=dirname($file);$file_name=basename($file);
    $ftp->delete($config->ftp['ftp_dir'].$dir_name,$file_name);
    $ftp->close();
    
    // uaktualnij ID pakietu 00006, w starszych wersjach pakiet 0006 byl wpisywany jako wersja 1
    $query="UPDATE upgrade SET id=6, version='6' WHERE filename='upgrade_eru1_30006.pkg' LIMIT 1";
    $result=$db->query($query);
    if ($result==0) print $db->error();
}

?>
