<?php
/**
* Obs³uga CVS, odczytywanie wersji itp.
* 
* @author  m@sote.pl
* @version $Id: cvs.inc.php,v 2.4 2004/12/20 17:59:20 maroslaw Exp $
* @package    admin_include
*/

/* Odczytaj dane z pliku  */
define ("CVS_FILE",1);   

/* Odczytaj dane z parametru */
define ("CVS_SOURCE",2);

/**
* Plik CVS
* @package upgrade
*/
class CVS {
    
    /**
    * @var string wiersz odpowiadajacy Id CVS
    */
    var $_line;
    
    /**
    * @var float numer wersji CVS pliku 
    */
    var $_version;
    
    /**
    * Konstruktor, odczytaj numer wersji pliku
    *
    * @param string $file   plik, bezwglêdna ¶cie¿ka do pliku
    * @param int    $source ¼ród³o sk±d brana jest zawarto¶æ pliku
    * @return bool
    */
    function CVS($file,$source=CVS_SOURCE) {        
        if ($source==CVS_FILE) {
            $fd=fopen($file,"r");
            $data=fread($fd,filesize($file));
            fclose($fd);
        } else $data=$file;
        
        $lines=split("\n",$data);
        foreach ($lines as $line) {
            if (ereg('\*(.)*@version(.)*\$Id',$line)) {
                //preg_match("/\$Id: cvs.inc.php,v 2.4 2004/12/20 17:59:20 maroslaw Exp $line,$matches);
                preg_match("/v ([0-9]+\.[0-9]+)/",$line,$matches);
                if (! empty($matches[1])) {
                    $this->_line=$line;
                    $this->_version=$matches[1];
                    return true;
                }
            }
        }
        return false;
    } // end CVS($file)
    
    /**
    * Odczytaj numer wersji pliku 
    * @return string numer wersji CVS
    */
    function getVersion() {
        return $this->_version;
    } // end getVersion();
    
    /**
    * Odczytaj numer wersji w postaci INT (wykorzystywane np. do porownania wersji plików)
    *
    * @param string numer wersji CVS
    * @param int    numer wersji liczbowy (INT)
    */
    function idCVS2Int($idcvs) {
        return intval(ereg_replace("\.","","$idcvs"));        
    } // end idCVS2Int()
    
} // end class CVS
?>
