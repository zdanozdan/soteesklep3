<?php
/**
* Odczytywanie danych z formatu CSV i przwtworzenie go na format tablicy PHP
*
* @author rdiak@sote.pl
* @version $Id: csv.inc.php,v 1.25 2005/09/02 08:10:13 lukasz Exp $
* @package    offline
* @subpackage main
*/


/**
* Klasa OfflineCSV
*
* @package offline
* @subpackage admin
*/
class OfflineCSV {
	var $filename='';                 // nazwa pliku ktory jest ladowany
	var $sep='';                      // separator jakie jest stosoany w pliku z danymi
	var $path='';                     // sciezka do pliku
	var $ftp_dir='';
	var $record=array();              // tablica ktora bedzie zawierac przetworzone rekordy
	var $check_encode=3;              // ile rekrd-Aów sprawdzamy stwierdzajac jake jest kodowanie.-B
	var $first_line='';               // czy pierwsza linia zawiera opis kolumn
    var $empty_line=0;                // ilosc pustych lini
	var $bools=array(10,11,12,13,14); // tablica pozycji przyjmuj±cych warto¶ci 1,0,NULL

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
	} // end OfflineCSV

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
				// jesli ju¿ by³o 10 pustych lini to przerwij bo prawdopodobnie do konca
				// pliku beda juz puste linie
				if($this->empty_line == 10) break;
				$buffer = fgets($fd,4096);
				if($buffer != '') {
					$table=split($this->sep,$buffer);
                    if($table[0]=='' && $table[1]=='' && $table[2]=='' && $table[3]=='' && $table[4]=='') {
                        $this->empty_line++;
                        continue;
                    }
                    // je¶li pole jest ró¿ne od jeden a nale¿y do tablicy bools - daj zero
                    foreach ($this->bools as $isNull) {
						if ($table[$isNull] != '1') {
						$table[$isNull]='0';
						}
					}
                    $this->empty_line = 0;
					if(count($table) < $this->get_count()){
						//$error->write($lang->offline_file_errors['less'],$i);
					} elseif(count($table) > $this->get_count()){
						//$error->write($lang->offline_file_errors['more'],$i);
					}
					if(count($table) != 1) {
						$table=$this->clean($table);
						array_push($this->record,$table);
					}
				} else {
                    $this->empty_line++;
                }
				$i++;
			}
			fclose($fd);
			// jesli pierwsza linia zawiera opis kolumn
			if($this->first_line) {
				$this->delete_first_line();
			}
			return $this->record;
		} else {
			print $lang->offline_file_errors['not_open'];
			return false;
		}
	} // end load_file

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
	} // end delete_first_line

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
	} // end clean

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
	} // end get_count
} // end class CSV

/**
* Klasa Parser
*
* @package offline
* @subpackage admin
*/
class Parser extends OfflineCSV {}
?>
