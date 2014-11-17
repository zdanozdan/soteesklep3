<?php
/**
* Generowanie pliku configuracyjnego PHP
*
* @author  m@sote.pl
* @version $Id: php.inc.php,v 2.18 2005/12/30 09:28:36 lukasz Exp $
* @package    admin_include
*/

/**
* @ignore
*/
class PHPFileTMP {}

define ("PHP_IN_OBJECT","in_object");
define ("PHP_IN_FILE","in_file");

/**
* Generuj pliki konfiguracyjne PHP
*/
class PHPFile {
    
    var $php_head="<?php\n";         // naglowek pliku PHP
    var $php_foot="?>";              // stopka pliku PHP
    var $vars=array();               // tablica za zmeinnymi generowanymi w tworzonej klasie
    var $spaces=16;
    
    /**
    * Otworz klase, lub otworz rozszezenie klasy
    *
    * @param string $classname nazwa klasy
    * @param class $ext klasa nadrzedna, ktora rozszezamy
    * @param strong $objectname nazwa obiektu tworzonego na podstawie generowanej klsasy $classname
    * \@global strong $this->php_classname
    */
    function start_class($classname,$ext="",$objectname="") {
        $this->php_classname=$classname;
        $this->php_objectname=$objectname;
        if (empty($ext)) {
            $this->start_class="class $classname {\n";
        } else {
            $this->start_class="class $classname extends $ext{\n";
        }
        
        return(0);
    } // end start_class()
    
    /**
    * Zamknij klase
    */
    function end_class() {
        $this->end_class="\n} // end class $this->php_classname\n";
        if (! empty($this->php_objectname)) {
            $this->end_class.="\$$this->php_objectname = new $this->php_classname;\n";
        }
        return(0);
    } // end end_class()
    
    /**
    * Dodaj zmienna
    *
    * @param string $name  nazwa zmiennej
    * @param string $value wartosc
    */
    function add($name,$value) {
        $this->vars[$name]=$value;
        return(0);
    } // end ad()
    
    /**
    * Usun zmienna
    *
    * @param string $name nazwa zmiennej
    */
    function delete($name) {
        $this->vars[$name]='';
        return(0);
    } // end delete()
    
    /**
    * Generuj kod PHP tablicy wielowymiarowej
    *
    * @param array  $values wartosci tablicy
    * @param int    $level  stopieñ zagnie¿d¿enia
    * @return string kod PHP definiujacy wartosc tablicy np. var $test=array("1"=>"A","2"=>"B");
    */
    function gen_array($values,$level=1) {
                
        $tab=str_repeat(str_repeat(" ",$this->spaces),$level);
        $php="array(\n";
        
        reset($values);
        foreach ($values as $key=>$val) {
            
            $php.=$tab."'$key'=>";
            
            if (is_array($val)) {                
                $php.=$this->gen_array($val,$level+1);                
            } else {                
                //$val=addslashes($val);                
                $val=ereg_replace('"','\"',$val);
                $val=preg_replace('/\\\$/','\ ',$val);
                $php.="\"$val\",";   
            }
            
            $php.="\n";
                        
        } // end foreach
        
        // obetnij ostatni znak ","
        $php=substr($php,0,strlen($php)-1);

        $php.="\n".$tab.")";        
        if ($level>1) $php.=",\n$tab";
        
        return $php;
    } // end array()
    
    /**
    * Generuj plik PHP
    *
    * @return string wygenerowany kod PHP
    */
    function gen_php_file() {
        $php="";
        $php.=$this->php_head."\n\n";
        if (! empty($this->start_class)) $php.=$this->start_class;
        while (list($name,$value) = each ($this->vars)) {
            if (is_array($value)) {
                // generuj tablice
                $php.="\tvar \$$name=".$this->gen_array($value).";\n";
            } else {                
                //$value=addslashes($value);
                //$value=ereg_replace("\'","'",$value);
                $value=ereg_replace('"','\"',$value);
                $value=preg_replace('/\$/','\\\$',$value);                
                $php.="\tvar \$$name=\"$value\";\n";
            }
        }
        if (! empty($this->start_class))  {
            $this->end_class();
            $php.=$this->end_class;
        }
        $php.=$this->php_foot;
        
        return $php;
    } // end gen_php_file()
    
    /**
    * Generuj kod PHP z warto¶ciami przypisanymi do danego obiektu
    *
    * @param string $object nazwa generowanego obiektu (warto¶ci s± przypisywane do tego obiektu)
    * @param array  $values warto¶ci zapisywane w w/w obiekcie
    * @return string PHP SOURCE
    */
    function genPHPFileValues($object,$values) {
        $this->php=$this->php_head;
        while (list($name,$value) = each ($values)) {
            if (is_array($value)) {
                // generuj tablice
                $this->php.="\$".$object."->".$name."=".$this->gen_array($value);
                $this->php.=";\n";
            } else {                
                //$value=addslashes($value);  
                //$value=ereg_replace("\'","'",$value);              
                $value=ereg_replace('"','\"',$value);
                $value=preg_replace('/\$/','\\\$',$value);
                $this->php.="\$".$object."->".$name."=\"$value\";\n";
            }
        }
        $this->php.=$this->php_foot;
        return $this->php;
    } // end getPHPFIleValues()
    
} // end class PHPFile

?>
