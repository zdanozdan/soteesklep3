<?php
/**
 * Klasa porownujaca dwie bazy danych i tworzaca plik roznicowy
 * Mozliwe sa nastepujace kombinacje
 * 1. Dwie bazy sa w bazie danych - musimy miec dostep do tych baz danych ( prawa )
 * 2. Stara baza w pliku, nowa w bazie danych
 * 3. Nowa baza w pliku, stara w bazie danych
 * 4. Dwie bazy w plikiach. 
 *
 * @author  r@sote.pl
 * @version $Id: db_compare.inc.php,v 1.9 2004/09/22 10:41:30 maroslaw Exp $
 * @package soteesklep
 */

include_once("include/metabase.inc");
include_once("table_compare.inc.php");

class DatabaseCompare {

	var $_drop=0;				// 0 (default ) - nie dolaczamy dropów 1 - dalaczamy dropy 
	var $_db_old_name='';		// nazwa starej bazy
	var $_db_new_name='';		// nazwa nowej bazy
	var $_db_old_from='db'; 	// db-baza jest w bazie danych file-baza jest w postaci na dysku
	var $_db_new_from='db'; 	// db- baza jest w bazie danych file- baza jest w postacina dysku
	var $_path_old='';			// sciezka do pliku z dumpem bazy danych
	var $_path_new='';			// sciezka do pliku z dumpem bazy danych
	var $_data_old=array();		// struktura w postaci tablicy
	var $_data_new=array();		// struktura w postaci tablicy
	var $table_compare='';		// obiekt do porownywania tabel
	var $prefix='/../sql';		// prefix sciezki
	var $changes='';			// lista zmian w postaci stringu
	var $_addsql='';			// dodatkowe instrukcje sql ktore maja byc dolaczone do pliku wynikowego
	
	/**
	* Kontruktor klasy
	*
	* @return bool
	*/
	function databasecompare() {
		$this->table_compare= new Tablecompare($this->_drop);
		return true;
	} // end DatabaseCompare

	/**
	* Funkcja glowna
	*
	* @return bool
	*/
	function action() {
		if($this->PrepareDb()) {
			$this->ParseTable("old");
			$this->ParseTable("new");
			$this->changes=$this->table_compare->DbDiff($this->_data_old,$this->_data_new);
			$this->SaveToFile();
			$this->addConfigField();
		}
		return true;
	} // end Action

	
	/**
	 * Dodaj do pliku user_config pola talicy main ktore sa indywidualne dla danego sklepu
	 *
	 * @return bool
	 */
	function addConfigField() {
    	global $sess;
   		$__fields=$this->table_compare->getFields();
   		$sess->register("__fields",$__fields);
     	return true;
	} // end addConfigField
	
	/**
	* Funkcja zapisuje zmiany w pliku roznicowym ktory mozna zaladowac do bazy danych
	*
	* @return bool
	*/
	function saveToFile() {
		global $DOCUMENT_ROOT;
		$file_patch=$DOCUMENT_ROOT."/tmp/diff.mysql";
		$fd=@fopen($file_patch,"w");
		if(!empty($this->_addsql)) {
			$this->changes.=$this->_addsql;
		}
		fwrite($fd,$this->changes,strlen($this->changes));
		fclose($fd);
		return true;
	} // end SaveToFile
	
	/**
	 * Funkcja ustawia dolaczenie dodatkowych instrukcji sql
	 * do pliku wynikowego	
	 *
	 * @param string or array  $data dodatkowe instrukcje sql      
	 *	
	 * @return bool
	 */
	function setAddFeatures(&$data) {
		if(is_array($data)) {
			foreach($data as $value) {
				$this->_addsql.=$value."\n";		
			}
		} else {
			$this->_addsql.=$data."\n";
		}
		return true;
	} // end SetAddFeatures
	
	/**
	 * Funkcja ustawia dolaczenie instrukcji drop
	 * jesli nie chcemy zeby tabele byly kasowane ustawiamy to na 0 ( domy¶lnie )
	 * jesli chcemy zeby byly kasowane ustawiamy na 1 
	 *
	 * @param string $status 0 lub 1      
	 *
	 * @return bool
	 */
	function SetDrop($status) {
		$this->_drop=$status;
		return true;
	} // end SetStatus

	/**
	 * Funkcja umozliwia ustawienie statusu ladowania bazy danych
	 * czy dana baza jest ladowana z pliku z z bazy danych
	 *
	 * @param string $type typ bazy danych ( stara czy nowa )
	 * @param string $status sk³adowanie bazy danych ( w pliku czy w bazie danych )       
	 *
	 * @return bool
	 */
	function setStatus($type,$status) {
		if($status != 'db' || $status != 'file' ) {
			if($type == 'old') {
				$this->_db_old_from=$status;
			} elseif ($type == 'new') {
				$this->_db_new_from=$status;
			}
		}
		return true;
	} // end SetStatus

	/**
	 * Funkcja umozliwia ustawienie statusu ladowania bazy danych
	 * czy mamy juz zrobionego dumpa czy nie
	 *
	 * @param string $type typ bazy danych ( stara czy nowa )
	 * @param string $dbname nazwa bazy danych       
	 *
	 * @return bool
	 */
	function setDbName($type,$dbname) {
		global $DOCUMENT_ROOT;
		if(!empty($dbname)) {
			if($type == 'old') {
				$this->_db_old_name=$dbname;
				$this->_path_old=$DOCUMENT_ROOT.$this->prefix."/".$dbname.".mysql";
			} elseif ($type == 'new') {
				$this->_db_new_name=$dbname;
				$this->_path_new=$DOCUMENT_ROOT.$this->prefix."/".$dbname.".mysql";
			} else return false;
		} else return false;
		return true;
	} // end SetDbName

	/**
	* Funkcja sprawdza ustawienie statusu ladowania bazy danych
	* i wywoluje odpowiednie funkcje
	*
	* @return bool
	*/
	function prepareDb() {
		global $mdbd;
		// jesli baza zrodlowa nie ma dumpa
		if($this->_db_old_from == 'db') {
			// wyciagnij strukture bazy danych z bazy
			$this->GetDbFromDb('old');
		} else {
			$this->GetDbFromFile('old');
		}
		// jesli baza docelowa nie ma dumpa
		if($this->_db_new_from == 'db') {
			// wyciagnij strukture bazy danych z bazy
			$this->GetDbFromDb('new');
		} else {
			$this->GetDbFromFile('new');
		}
		return true;
	} // end PrepareDb

	/**
	* Funkcja w zalaznosci od zmiennej status tworzy tablice ze struktury bazy danych
	* na podstawie bazy danych
	*
    * @param string $status type bazy danych ( stara czy nowa )       
	*
	* @return bool
	*/
	function getDbFromDb($status) {
		global $database;

		if(!empty($status)) {
			// jesli stara baze danych trzeba wyciagac z bazy danych
			if($status == 'old') {
				$data=$database->sql_select_show("SHOW TABLES FROM ".$this->_db_old_name,"Tables_in_".$this->_db_old_name);
				foreach($data as $key=>$value) {
					$struct=$database->sql_select_show("SHOW CREATE TABLE ".$this->_db_old_name.".".$value,"Create Table");
					$struct[0]=ereg_replace("`","",$struct[0]);
					$table=split("\n",$struct[0]);
					$this->_data_old=$this->_data_old+array($value=>$table);

				}
			} elseif($status == 'new') {
				$data=$database->sql_select_show("SHOW TABLES FROM ".$this->_db_new_name,"Tables_in_".$this->_db_new_name);
				foreach($data as $key=>$value) {
					$struct=$database->sql_select_show("SHOW CREATE TABLE ".$this->_db_new_name.".".$value,"Create Table");
					$struct[0]=ereg_replace("`","",$struct[0]);
					$table=split("\n",$struct[0]);
					$this->_data_new=$this->_data_new+array($value=>$table);
				}
			} else return false;
		}
		return true;
	} // end GetDbFromDb

	/**
	* Funkcja wyciaga nazwy tabele z baz danych
	*
    * @param string $status type bazy danych ( stara czy nowa )       
	*
	* @return bool
	*/
	function getDbFromFile($status) {
		$str=array();
		if(!empty($status)) {
			if($status == 'new') {
				if(file_exists($this->_path_new)) {
					$fp=fopen($this->_path_new,"r");
					while($line=@fgets($fp,50000)) {
						if(ereg("^#",$line) || ereg("^--",$line) || ereg("^\n$",$line) ||ereg("^INSERT", $line)) continue;
						if(ereg("^CREATE TABLE",$line)) {
							array_push($str,$line);
							preg_match ("/^[ ]*CREATE[ ]+TABLE[ ]+([^ ]+)[ ]+\([ ]*$/",$line,$data);							
						} else {
							if(!ereg("^)[ ]+TYPE",$line)) {
								array_push($str,$line);
							} else {
								array_push($str,$line);
								$this->_data_new=$this->_data_new+array($data[1]=>$str);
								$str=array();
							}
						}
					}
				} else {
					print "Nie mogê otworzyc pliku $this->_path_new <br>";
				}
			} elseif( $status == 'old') {
				if(file_exists($this->_path_old)) {
					$fp=fopen($this->_path_old,"r");
					while($line=@fgets($fp,50000)) {
						if(ereg("^#",$line)) continue;
						if(ereg("^\n$",$line)) continue;
						if(ereg("^INSERT", $line)) continue;
						if(ereg("^CREATE TABLE",$line)) {
							array_push($str,$line);
							preg_match ("/^[ ]*CREATE[ ]+TABLE[ ]+([^ ]+)[ ]+\([ ]*$/",$line,$data);
						} else {
							if(!ereg("^)[ ]+TYPE",$line)) {
								array_push($str,$line);
							} else {
								array_push($str,$line);
								$this->_data_old=$this->_data_old+array($data[1]=>$str);
								$str=array();
							}
						}
					}
				} else {
					print "Nie mogê otworzyc pliku".$this->_path_old."<br>";
				}
			} else return false;
		}
		return true;
	} // end GetDbFromFile

	/**
	 * Funkcja parsuje tabele i tworzy tablice asoacjacyjen opisujace kazda
	 * tabele
	 *
	 * @param string $status type bazy danych ( stara czy nowa )       
	 *
	 * @return bool
	 */
	function parseTable($status) {
		// w zleznosci od tego jaka jest wartosc zmiennej status taka
		// tablice obrabiamy
		if($status == 'new') {
			$temp1=$this->_data_new;
		} elseif($status == 'old') {
			$temp1=$this->_data_old;
		} else return false;
		$temp=array();
		foreach($temp1 as $key=>$value) {
			$def='';
			$temp[$key]['lines']=$value;
			$temp[$key]['indices']=array();
			$temp[$key]['unique_index']=array();
			$temp[$key]['fulltext']=array();
			$temp[$key]['fields']=array();
			foreach($value as $line) {
				$def.=$line."\n";
				// Jesli linia Create Table to idz dalej
				if (preg_match ("/\s*CREATE\s+TABLE\s+(\S+)\s+\(\s*/",$line,$table)) {
					continue;
				}
				// jesli znalazles klucz glowny to zapisz go
				if(preg_match ("/PRIMARY[ ]+KEY\s+(.+)/",$line,$pk)) {
					$pk[1]=ereg_replace(",$","",$pk[1]);
					$temp[$key]['primary_key']=$pk[1];
					continue;
				}
				// jesli znalazles pelnotekstowy index
				if(preg_match ("/(FULLTEXT(?: KEY|INDEX)?)\s+(\S+?)\s*\((.*)\)/",$line,$full)) {
					$full[3]=ereg_replace(",$","",$full[3]);
					$temp[$key]['fulltext']=$temp[$key]['fulltext']+array($full[2]=>$full[3]);
					continue;
				}
				// jesli znalazles index lub unique
				if(preg_match ("/(KEY|UNIQUE(?: KEY)?)\s+(\S+?)\s*\((.*)\)/",$line,$keys)) {
					$keys[3]=ereg_replace(",$","",$keys[3]);
					$temp[$key]['indices']=$temp[$key]['indices']+array($keys[2]=>$keys[3]);
					if($keys[1] == "UNIQUE") {
						$tmp=1;
					} else {
						$tmp='';
					}
					$temp[$key]['unique_index']=$temp[$key]['unique_index']+array($keys[2]=>$tmp);
					continue;
				}
				// jesli jest to koniec definicji tabeli
				if(preg_match ("/\)\s*(TYPE.*?)$/",$line,$opt)) {
					$opt[1]=ereg_replace(";$","",$opt[1]);
					$temp[$key]['options']=$opt[1];
					break;
				}
				// jesli jest to zwykle pole tabeli
				if (preg_match ("/(\S+)\s*(.*)/",$line,$fields)) {
					$fields[2]=ereg_replace(",$","",$fields[2]);
					$temp[$key]['fields']=$temp[$key]['fields']+array($fields[1]=>$fields[2]);
					continue;
				}
			}
			// zapisz pelna definicje tabeli.
			$def=ereg_replace("\n$","",$def);
			$temp[$key]['def']=$def.";\n";
		}
		if($status == 'new') {
			$this->_data_new=$temp;
		} elseif($status == 'old') {
			$this->_data_old=$temp;
		} else return false;
		return true;
	} // end ParseTable
} // end class DatabaseCompare
?>