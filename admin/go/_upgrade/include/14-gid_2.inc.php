<?php
/**
* Skrypt wywolywany po zaladowniu pakietu z gid=2
* Uaktualnienie sum kontrolnych wg listy aktualnych pakietów.
*
* @author  m@sote.pl
* @version $Id: gid_2.inc.php,v 1.9 2004/12/20 17:59:11 maroslaw Exp $
* @package    upgrade
*/

if (file_exists("$DOCUMENT_ROOT/upgrade/upgrade_eru1_30006.pkg")) {
    // zainstalowano poakiet 0006
    $s9=$mdbd->select("version","`upgrade`","version=6",array(),"LIMIT 1");
    if ($s9!=6) {
        $mdbd->insert("`upgrade`","version,date_add,filename","?,?,?",array(
        "6"=>"int",
        date("Y-m-d")=>"text",
        "upgrade_eru1_30006.pkg"=>"text")
        );
        
    } // end if ($s9!=6)
    
} // end file_exists ... 0006.pkg

if (file_exists("$DOCUMENT_ROOT/upgrade/upgrade_hue8_30009.pkg")) {
    // zainstalowano pakiet 0009
    $s9=$mdbd->select("version","`upgrade`","version=9",array(),"LIMIT 1");
    if ($s9!=9) {
        $mdbd->insert("`upgrade`","version,date_add,filename","?,?,?",array(
        "9"=>"int",
        date("Y-m-d")=>"text",
        "upgrade_hue8_30009.pkg"=>"text")
        );
    }
}

/**
* Start FC 15
*
* Uaktualnienie sum kontrolnych ponizszych plików
* W kolejnych modyfikacjach nalezy usun±c poni¿szy kod, gdy¿ po uaktualnieniu
* sum kontrolnych plikow z 0006 nie jest ju¿ on potrzebny
*/
if ((file_exists("$DOCUMENT_ROOT/upgrade/install_15.inf"))  && (! file_exists(".0015"))) {

    /**
    * Dodaj obs³ugê FTP
    */  
    require_once ("include/ftp.inc.php");
    
    // generuj lista plikow z sumami kontrolnymi (do uaktualnienia)
    $files=array();$sums=array();
    $fmd5="$DOCUMENT_ROOT/go/_upgrade/config/current.md5";
    $fd=fopen($fmd5,"r");
    $data=fread($fd,filesize($fmd5));
    fclose($fd);
        
    
    $lines=split("\n",$data,100000);
    reset($lines);
    foreach ($lines as $line) {        
        $tab=split(" ",$line);        
        if (! empty($tab[1])) {
            $files[$tab[0]]=$tab[1];            
        }
    }
    
    
    // oblicz sume kontrolna dla kazdego z w/w plikow
    require_once ("include/file_checksum.inc.php");
    reset($files);
    foreach ($files as $sum2=>$file) {        
        $file_path=preg_replace("/^./","$DOCUMENT_ROOT/..",$file);        
        
        $fc =& new FileChecksum($file_path,FILE_CHECKSUM_FILE);
        $sum1=$fc->getChecksum();                
        
        if ($sum1==$sum2) {
            $fc->set($file,$sum2);       
        }        
        
    } // end foreach
    
    // zapisz nowy plik sum kontrolnych
    FileChecksum::saveDat();
    
    
    $fd=fopen("$DOCUMENT_ROOT/tmp/.0015","w+");
    fwrite($fd,"Done",4);
    fclose($fd);
    
    $ftp->connect();
    $ftp->put("$DOCUMENT_ROOT/tmp/.0015",$config->ftp['ftp_dir']."/admin/go/_upgrade",".0015");
    $ftp->close();
}
/**
* End FC 15
*/
?>
