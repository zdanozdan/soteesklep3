<?php
/**
* Obs³uga sum kontrolnych plików
*
* @author  m@sote.pl
* @version $id$
* @package    admin_include
*/

/* Odczytaj dane z pliku */
define ("FILE_CHECKSUM_FILE",1);

/* Odczytaj dane z parametru */
define ("FILE_CHECKSUM_SOURCE",2);

/* Domy¶lny plik z baz± sum kontrolnych */
define ("FILE_CHECKSUM_DEFAULT","sum.md5");

/**
* Suma kontrolna pliku
* @package upgrade
*/
class FileChecksum {

    /**
    * Nazwa pliku, z którego odczytujemy sumy kontrolne
    * Warto¶æ musi byæ zgodna ze sta³± FILE_CHECKSUM_DEFAULT
    */
    var $_sum_md5="sum.md5";

    /**
    * @var string bezwzglêdna ¶cie¿ka do pliku
    */
    var $_file;

    /**
    * Konstruktor
    *
    * @param string $file     plik, bezwglêdna ¶cie¿ka do pliku
    * @param string $source   ¼ród³o sk±d s± pobierane dane z pliku
    * @param string $file_sum plik z baz± sum kontrolnych
    * @return bool
    */
    function FileChecksum($file,$source=FILE_CHECKSUM_SOURCE,$file_sum='') {
        global $__database_md5,$DOCUMENT_ROOT;

        if (! empty($file_sum)) {
            $this->setVar("_sum_md5",$file_sum);
        }

        if (empty($__database_md5)) {
            $file_dat="$DOCUMENT_ROOT/../$this->_sum_md5";
            $fd=@fopen($file_dat,"r");
            if ($fd) {
                $data=fread($fd,filesize($file_dat));
                fclose($fd);

                $lines=split("\n",$data);
                foreach ($lines as $line) {
                    $tab=split(" ",$line,2);
                    if (! empty($tab[1])) {
                        $__database_md5[trim($tab[1])]=trim($tab[0]);
                    }
                } // end foreach
            } else {
                $__database_md5=array();
            }
        } // end if

        if ($source==FILE_CHECKSUM_FILE) {
            if (file_exists($file)) {
                $fd=fopen($file,"r");
                $this->_file=fread($fd,filesize($file));
                fclose($fd);
                return true;
            }
        } else {
            if (! empty($file)) {
                $this->_file=$file;
                return true;
            }
        }
        return false;
    } // end FileChecksum()

    /**
    * Ustaw warto¶æ danych w obiekcie
    *
    * @param string nazwa zmiennej
    * @param mixed  warto¶æ
    * @return none
    */
    function setVar($var,$value) {
        $this->$var=$value;
        return;
    } // end setVar()

    /**
    * Wstaw plik bazy sum kontrolnych (wzgledem glownego katalogu sklepu)
    *
    * @param string $file plik z baz± sum kontrolnych
    * @return bool
    */
    function setSumDB($file) {
        global $DOCUMENT_ROOT;
        $f="$DOCUMENT_ROOT/../$file";
        if (file_exists($f)) {
            $this->_sum_md5=$file;
            return true;
        } else return false;
    } // end setSumDB()

    /**
    * Generuj sumê kontroln± z aktualnego pliku
    */
    function getChecksum() {
        return md5($this->_file);
    } // end getChecksum()

    /**
    * Odczytaj sumê kontroln± z bazy sum kontrolnych
    *
    * @param string $file ¶cie¿ka fo pliku okre¶laj±ca jego po³o¿enie wzglêdem g³ównego katalogu sklepu np. ./admin/index.php
    */
    function getChecksumFromDAT($file) {
        global $DOCUMENT_ROOT,$__database_md5;
        if (! empty($__database_md5[$file])) return $__database_md5[$file];
        return false;
    } // end _getChecksum()

    /**
    * Odczytaj datê modyfikacji pliku
    */
    function getModifydate() {
        return;
    } // end getModifyDate()

    /**
    * Ustaw sumê kontroln± dla pliku
    *
    * @param string $file     ¶cie¿ka fo pliku np. ./admin/index.php
    * @param string $checksum suma kontrolna
    * @return bool
    */
    function set($file,$checksum) {
        global $__database_md5;
        if ((! empty($__database_md5)) || ($this->_sum_md5!=FILE_CHECKSUM_DEFAULT)) {
            $__database_md5[$file]=$checksum;
            return true;
        }
        return false;
    } // end set()

    /**
    * Zapisz now± bazê sum kontronych na podstwei danych z $__database_md5
    * FileChecksum::saveDAT()
    *
    * @return bool
    */
    function saveDAT() {
        global $ftp,$__database_md5,$DOCUMENT_ROOT,$config;

        $fs='';reset($__database_md5);
        foreach ($__database_md5 as $file=>$checksum) {
            $fs.="$checksum  $file\n";
        }

        if (empty($this->_sum_md5)) $file_sum_md5=FILE_CHECKSUM_DEFAULT;
        else $file_sum_md5=$this->_sum_md5;

        $file_tmp="$DOCUMENT_ROOT/tmp/$file_sum_md5";

        if ($fd=fopen($file_tmp,"w+")) {
            fwrite($fd,$fs,strlen($fs));
            fclose($fd);
        } else {
            return false;
        }

        $ftp->connect();
        $ftp->put($file_tmp,$config->ftp['ftp_dir'],$file_sum_md5);
        $ftp->close();

        return true;
    } // end saveDAT()

} // end FileChecksum
?>
