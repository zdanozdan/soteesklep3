<?php
/**
 * Odczytywanie danych z formatu CSV i przwtworzenie go na format tablicy PHP
 *
 * @author rdiak@sote.pl
 * @version $Id: csv.inc.php,v 1.3 2005/09/02 08:21:36 lukasz Exp $
* @package    admin_include
 */

class OfflineCSV {
    var $filename='';                 // nazwa pliku ktory jest ladowany
    var $sep='';                      // separator jakie jest stosoany w pliku z danymi
    var $path='';                     // sciezka do pliku 
    var $ftp_dir='';
    var $record=array();              // tablica ktora bedzie zawierac przetworzone rekordy
    var $check_encode=3;              // ile rekrd-Aów sprawdzamy stwierdzajac jake jest kodowanie.-B
    var $first_line='';               // czy pierwsza linia zawiera opis kolumn

    /**
     * Konstruktor obiektu CSV 
     *
     * @return bool  
     *
     * @author rdiak@sote.pl
     */

    function OfflineCSV () {
        global $config;
        global $DOCUMENT_ROOT;
        
        $this->filename=$config->offline_filename;
        $this->sep=$config->offline_separator;
        $this->path=$config->offline_path_file;
        $this->first_line=$config->offline_first_line;
        $this->ftp_dir=$DOCUMENT_ROOT;
        return true;
    }
    
    /**
     * Funkcja ³aduj±ca plik do tablicy ktorej polami sa tablice
     *
     * @return boolean true/false
     *
     * @author       rdiak@sote.pl
     */

    function load_file() {
        
        global $error;
        global $lang;
        
        $file=$this->ftp_dir."/".$this->path."/".$this->filename;
        //        print $file;
        $fd=fopen($file,"r");
        if($fd) {
        	$i=0;
	  		while (!feof ($fd)) {
        		$buffer = fgets($fd,4096);
            	if($buffer != '') {
            		$table=split($this->sep,$buffer);
                	if(count($table) < $this->get_count()){
                		$error->write($lang->offline_file_errors['less'],$i);
                	} elseif(count($table) > $this->get_count()) {
                    	$error->write($lang->offline_file_errors['more'],$i);
                	}
                	if(count($table) != 1) {
		        		$table=$this->clean($table);
			 			array_push($this->record,$table);
		    		}
            	}
				$i++;
        	}
        	fclose($fd);
        	// jesli pierwsza linia zawiera opis kolumn
        	if($this->first_line == 'true') {
            	$this->delete_first_line();
        	}
        	return $this->record;
        	//print_r($this->record);
        } else {
            print $lang->offline_file_errors['not_open'];
            return false;
        }
    }
    
    /**
     * Funkcja kasuje pierwsza linie danych
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    function delete_first_line() {
        array_shift($this->record);
        return true;
    }
    
    /**
     * Funkcja czyszczaca dane z bia³ych znaków
     *
     * @param  string $str  string który czy~cimy z bia~ych znaków, 
     * @return string $str  string oczysczony z bialych znakow 
     *
     * @author              rdiak@sote.pl
     */
    
    function clean($table) {
        $my_tab=array();
        foreach($table as $value) {
            $value = ltrim($value); 
            $value = rtrim($value); 
            array_push($my_tab,$value);
        }
        return $my_tab;
    }
 
    /**
     * Pobierz aktualna liczbe pol ktore updatejtujemy
     * Przyk³ad: $count=$get_count();
     *
     * @return int $count   ilosc pol rekordu  
     *
     * @author              rdiak@sote.pl
     */

    function get_count(){
        global $config;
        if($config->offline_load_mode == 'true') {
            $count=count($config->offline_file_struct);
        } else {
            $count=count($config->offline_current_columns);         
        }
        return $count;
    }
} // end class CSV

class Parser extends OfflineCSV {}
?>
