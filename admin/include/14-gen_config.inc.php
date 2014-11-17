<?php
/**
* Generuj plik konfiguracyjny na podstawie danych z tablicy. Metoda ta sluzy do generowanie danych
* z tabel SQL, ktore sa dostepne w postaci tablic PHP. Pozwala to na zaoszczedzenie czasu zwiazanego
* z wykonywaniem zapytan SQL i dobieraniem danych. Metoda jest zalecana dla generowania danych, ktore sa
* zcesto wykorzystyweane w sklepie, np. do cen, walut, rabatow, kodowania hasla dostepu do bazy itp.
*
* @author  m@sote.pl
* @version $Id: gen_config.inc.php,v 2.25 2005/04/01 08:35:33 maroslaw Exp $
* @package    admin_include
*/

/**
* @ignore
* @package admin
* @subpackage config
*/
class NullClass {}

/**
* Dodaj obs³ugê generowania kodu PHP.
*/
require_once ("include/php.inc.php");

/**
* Dodaj obs³ugê FTP.
*/
require_once ("include/ftp.inc.php");

/**
* Generowanie, pobranie i wrzucenie w odpowiednie wskazane miejsce plików konfiguracyjnych PHP.
* @package admin
* @subpackage config
*/
class GenConfig {
    
    /**
    * @var string Katalog zawierajacy generowany plik konfiguracyjny
    */
    var $config_dir="";
    
    /**
    * @var string Generowany plik konfiguracjny
    */
    var $config_file="";
    /*
    * @var string Nazwa klasy zawierajace definicje konfiguracyjne
    */
    var $classname;
    
    /**
    * @var string Jesli $classname jest rozszezeniem jakiejs klasy to $ext_classname wskazuje na ta klase
    */
    var $ext_classname="";
    
    /**
    * @var object obiekt $classname
    */
    var $obj_config;
    
    /**
    * @var string Automatycznie polacz sie z serwerem FTP wg danych z configu
    */
    var $auth_from_db="yes";
    
    /**
    * @var string User  ftp, jesli nie laczymy sie automatycznie
    */
    var $ftp_user;
    
    /**
    * @var string Has³o ftp
    */
    var $ftp_password;
    
    /**
    * @var string Serwer ftp
    */
    var $ftp_host;
    
    /**
    * @var bool Czy automatycznie ³±czyæ siê przez FTP.
    */
    var $auto_ftp=true;
    
    /**
    * Generuj plik konfiguracyjny PHP. Odczytaj dane do zmian przekazane jako parametr, pozostale dane
    * odczytaj z biezacej konfiguracji.
    *
    * @param array $vars zmienna=>wartosc parametry zapisywane w pliku konfiguracyjnym
    * \@depend $config->user_vars
    * @access private
    */
    function _gen($vars) {
        global $config;
        global $DOCUMENT_ROOT;
        
        // odczytaj aktualne wartosci zdefiniowane w obiekcie, w ktorym przechowywane sa wartosci wszystkich zmiennych
        // generowanych przez wywolanie tej. klasy (dla danej grupy zmiennych)
        if (empty($this->config)) {
            $this->config =& new NullClass; // wymagane kiedy tworzymy plik i potrzebujemy obiekt klasy z pliku,
            // ktory jeszcze nie zostal wygenerowany
        }
        $obj_config=&$this->config;
        
        $php =& new PHPFile;
        $php->start_class($this->classname,$this->ext_classname,$this->class_object);
        
        reset($this->vars);
        foreach ($this->vars as $var) {
            // sprawdz czy dana wartosc jest podana w parametrze $vars jako klucz
            reset($vars);$in_param=false;
            while (list($key,) = each($vars)) {
                if ($key==$var) {
                    $in_param=true;
                }
            }
            
            if ($in_param==true) {
                // zmienna przekazana jako parametr
                $val=$vars[$var];
                $php->add($var,$val);
            } else {
                // odczytaj wartosc z biezacej konfiguracji
                if (isset($obj_config->$var)) {
                    $val=$obj_config->$var;
                    $php->add($var,$val);
                } else $val='';
            }
        } // end foreach
        
        $src_php=$php->gen_php_file();
        
        // zapisz dane w pliku konfiguracyjnym
        $file="$DOCUMENT_ROOT/tmp/$this->config_file";
        if ($fd=fopen($file,"w+")) {
            fwrite($fd,$src_php,strlen($src_php));
            fclose($fd);
        } else die ("Forbidden $file");
        
        // przerzuc plik poprzez FTP do wlasciwego miejsca
        global $ftp;
        if ($this->auth_from_db=="no") {
            $ftp->ftp_user=$this->ftp_user;
            $ftp->ftp_password=$this->ftp_password;
            $ftp->ftp_host=$this->ftp_host;
        }
        if ($this->auto_ftp==true) $ftp->connect($this->auth_from_db);
        $ftp->put($file,$config->ftp['ftp_dir'].$this->config_dir,$this->config_file);
        if ($this->auto_ftp==true) $ftp->close();
        
        return(0);
    } // end gen()
    
    /**
    * @see gen
    */
    function genPHPFileClass($vars) {
        return $this->_gen($vars);
    } // end genPHPFileClass
    
    /**
    * Alias do genPHPFileClass
    * @deprecate since 3.0
    */
    function gen($vars) {
        return $this->genPHPFileClass($vars);
    } // end gen()
    
    /**
    * Generuj plik PHP z konfiguracj±.
    * Plik zawiera przypisania waerto¶ci do obiektu postaci np. $lang->zmienna="1123";
    *
    * @param string $object nazwa zmiennej reprezentuj±cej obiekt
    * @param string $file   nazwa pliku (wzglêdem DOCUMENT_ROOT), który bêdzie generowany
    * @param array  $values tablica z warto¶ciami, które zostan± podmienione w w/w pliku
    * @return bool true - dane zosta³y zaktualizowane, false w p.w.
    */
    function genPHPFileValues($object,$file,$values) {
        global $DOCUMENT_ROOT;
        global $ftp,$config;
        
        $php =& new PHPFile;
        
        $file_name=basename($file);
        $file_dir=substr($file,0,strlen($file)-strlen($file_name));
        
        // Kopiujemy plik po to,¿eby moc go odczytaæ, bez wzglêdu na to czy wcze¶niej
        // by³ ³adowany czy nie. Bez kopiwania, je¶li plik by³ wcze¶niej wywo³ywany przez
        // np. include_once, nie bedziemy mogli go ponownie odczytaæ.
        $from_file=$DOCUMENT_ROOT."/../".$file;
        $dest_file=$DOCUMENT_ROOT."/tmp/gen_php_file_tmp.php";
        $dest_file_2=$DOCUMENT_ROOT."/tmp/gen_php_file_tmp_2.php";
                        
        $ftp->connect();
        
        if (file_exists($from_file)) {
            // kopiujemy istniejacy plik
            if (copy($from_file,$dest_file)) {
                $$object =& new PHPFileTMP();
                include($dest_file);
                
                // przeksztalcenie elementow obiektu na tablicê
                $cur_values = array($$object);$cur_values = $cur_values[0];
                reset($cur_values);$new_values=array();
                while (list($key,$val) = each($cur_values)) {
                    if (! is_array($val)) $val=stripslashes($val);
                    $new_values[$key]=$val;
                }
                // end
                
                // podstaw przekazane do podmiany zmienne
                reset($values);
                while (list($key,$val) = each($values)) {
                    $new_values[$key]=$val;
                }
                // end
                
                $php_source=$php->genPHPFIleValues($object,$new_values);
            } else {
                return false;
            }
        } else {
            // sprawdzamy czy istnieje wskazany katalog
            // $file_dir -> /htdocs/1/lang/_pl/
            $dir_1=$config->ftp['ftp_dir']."/".$file_dir;
            $ftp->mkdir($dir_1);
                
            // tworzymy nowy plik
            if ($fd=fopen($dest_file_2,"w+")) {
                $$object =& new PHPFileTMP();
                $php_source=$php->genPHPFIleValues($object,$values);
                fclose($fd);
            } else return false;
        }
                
        // zapisz wygenerowany kod PHP w pliku
        if ($fd=fopen($dest_file_2,"w+")) {
            fwrite($fd,$php_source,strlen($php_source));
            fclose($fd);
        } else return false;
        
        // skopiuj plik do docelowej lokalizacji
        $ftp->put($dest_file_2,$config->ftp['ftp_dir']."/".$file_dir,$file_name);
        $ftp->close();
        
        // skasuj niepotrzebne ju¿ pliki
        if (file_exists($dest_file))   unlink ($dest_file);
        if (file_exists($dest_file_2)) unlink ($dest_file_2);
        
        return true;
    } // end genPHPFileValues()
    
} // end class GenConfig

/*
// Przyklad generowania podmiany zmienny w pliku z warto¶ciami przypisanymi do danego obiektu
require_once ("include/gen_config.inc.php");
$gen_config =& new GenConfig();
$gen_config->genPHPFileValues("lang","./htdocs/1/lang/_pl/lang.inc.php",array("zmienna1"=>"Smok","zmienna3"=>"Wawelski"));
*/
?>
