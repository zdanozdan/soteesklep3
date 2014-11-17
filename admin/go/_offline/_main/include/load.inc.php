<?php
/**
 * Klasa zawierajaca funkcje bezposredniego ladowania danych do bazy danych
 *
 * @author rdiak@sote.pl
 * @version $Id: load.inc.php,v 2.50 2006/04/07 07:55:51 lukasz Exp $
* @package    offline
* @subpackage main
 */

/**
* Includowanie potrzebnych klas 
*/
require_once("include/metabase.inc");
require_once("include/category/main_category.inc");
require_once("./include/form_check_functions.inc.php");
require_once("./include/encode.inc.php");

/**
 * Klasa OfflineLoad
 *
 * @package offline
 * @subpackage admin
 */
class OfflineLoad {
	
	var $mode='';                   // true - sa ladowane wszystkie dane false - dane do okreslonych kolumn
	var $table='';                  // nazwa tablicy do ktorej ladowane sa dane
	var $struct=array();            // zawiera albo stukture tablicy $config->offline_file_struct albo $config->offline_current_columns
	var $count='';                  // ilosc pol w rekordzie ladowanym do bazy danych
	var $record_hash=array();       // aktualnie obrabiany rekord w postaci tablicy asoscjancyjnej
	var $field_sql='';              // pole ktore jest uzywane w warunku where sql
	var $offline_mode='';           // tryb pracy offline
	var $count_record='';           // ilosc zaladowanych rekordow
	var $count_limit='';            // ilosc dozwolonych do zaladowania rekordow
	var $record_add=0;				// ilosc rekordow dodanych
	var $record_update=0;			// ilosc rekordow zaktualizowanych
	var $record_delete=0;           // ilosc rekordow skasowanych
    var $status_field='';			// pole statusu z configa informujace
	var $number='';				    // numer aktualnie ³adowanego rekordu
    var $error='';				    // numer bledu
    var $error_add='';				// dodatkowa informacja o bledach
	
	/**
	* Konstruktor obiektu OfflineLoad inicjuje zmienne
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
	function OfflineLoad() {
		global $config;
		// tymczasowo zdefiniowana zmienna
		global $update_mode;
		
		$this->mode=$config->offline_load_mode;
		$this->table=$config->offline_table;
		$this->count_limit=hexdec($config->offline_nccp);
		$this->field_sql=$config->offline_field_sql;
		$this->offline_mode=$update_mode;
		//$this->offline_mode=$config->offline_mode;
		if($config->offline_load_mode == 'true') {
			$this->struct=$config->offline_file_struct;
		} else {
			$this->struct=$config->offline_current_columns;
		}
        $this->status_field=$config->offline_status_field;
		$this->count=count($this->struct);
		$this->count_record=$this->load_compute();
		return true;
	} // end OfflineLoad
	
	/**
	* Funkcja sprawdzajace dane w rekordzie
	*
	* @param  array $record  jeden rekod w postaci tablicy,
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
	function check_record($record,$number) {
		global $error;
		global $lang;

		$this->number=$number;	
		$data=array();
		$form_check= new FormCheckFunctions;
		$form_check->fun=$this->struct;
		$form_check->errors=$lang->offline_check_errors;
		$i=0;
		foreach($this->struct as $key => $value) {
			$data = $data+array($key=>@$record[$i]);
			$i++;
		}
		//print "<pre>";
		//print_r($data);
		//print "</pre>";
		$this->record_hash=$data;
		$form_check->form=&$this->record_hash;
		if($form_check->form_test()) {
			return true;
		} else {
			foreach($form_check->errors_found as $key => $value ) {
				$error->write($value,$number,$key);
			}
			return false;
		}
	} // end check_record
	
	/**
	* Funkcja sprawdzajace dane przed wprowadzeniem ich do bazy danych
	*
	* @param  array   $data      jeden rekord w postaci tablicy asocajacyjnej
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
	function check_record_database($data) {
		global $error;
		global $lang;
		
		$form_check->fun=$this->struct;
		$form_check->errors=$lang->offline_database_errors;
		
		$form_check->form=&$data;
		if($form_check->form_test()) {
			return true;
		} else {
			foreach($form_check->errors_found as $key => $value ) {
				$error->write($value,$number,$key);
			}
			return false;
		}
	} // end check_record_database
	
	/**
	* Funkcja ladujacja poszczegolne rekordy do bazy danych
	*
	* @param  array $record  jeden rekod w postaci tablicy,
	* @param  int   $number  numer rekordu
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
	
	function load_record($record,$number) {
		global $error;
		global $lang;
		
		//print "load record.....";
//		if($record[0] != 'A') {
//			$test=1;
//		} else {
			if($this->count_record < $this->count_limit) {
				$test=1;
			} else {
				$test=0;
			}	
//		}
		if($test) {
			if($this->check_record($record,$number)) {
	            if($this->status_field == 'true') {
					if($record[0] == 'A' || $record[0] == 'a') {
						array_shift($this->record_hash);
						$result = $this->insert_data();
						if(!$result) {
							$error->write_other($lang->offline_file_errors['error_insert'],$number);
						} else {
							$this->count_record++;
						}
					} elseif ($record[0] == 'U' || $record[0] == 'u') {
						array_shift($this->record_hash);
						$result = $this->update_data();
						if(!$result) {
							$error->write_other($lang->offline_file_errors['error_update'],$number);
						}
					} elseif ($record[0] == 'D' || $record[0] == 'd') {
						array_shift($this->record_hash);
						$result = $this->delete_data();
						if(!$result) {
							$error->write_other($lang->offline_file_errors['error_delete'],$number);
						} else {
							$this->count_record--;
						}
					} else {
						// jesli pole "co zrobic z rekordem jest puste"
						$result = 1;
					}
	            } else {
	            	$result = $this->insert_data();
	            	if(!$result) {
	            		$error->write_other($lang->offline_file_errors['error_insert'],$number);
	            	} else {
	            		$this->count_record++;
	            	}
	            }		
				if($result) {
					$this->error=1;
				} else {
					$error->write_other($lang->offline_file_errors['load_database'],$number);
					$this->error=3;
				}
			} else {
				$this->error=2;
			}
		} else {
			$error->write_other($lang->offline_file_errors['load_ignore'],$number);
			// rekody nie zaladowane ze wzgledu na ograniczenia
			$this->error=4;
		}
		return $this->error;
	} // end load_record
	
   /**
	* Funkcja prepare_data tworzy tablica asocajacyjna ktora jest wykorzystywana w funkcjach ladujacych dane do bazy
	*
	* @return int    $data       tablica asocjacyjna
	*
	* @author rdiak@sote.pl
	*/
	function & prepare_data() {
		global $config;
		global $category;
		global $encode;
		global $DOCUMENT_ROOT;
		global $error;
		global $lang;
		
		$path_file="$DOCUMENT_ROOT/tmp/product";
		
		$data=array();
		// przechodzimy przez cala tablice $config->offline_relation
		foreach($config->offline_relation as $key => $value) {
			foreach($this->record_hash as $key1 => $value1) {
				if($value1 != '') {
					$value1=$encode->encoding_win1250_to_8859($value1);
					// nie wyrzucamy cudzyslowo jezeli operujemy na opisach produktow (to moze byc HTML!)
					if (!preg_match("/description/",$key1)) {
						$value1=preg_replace("/\"/","''", $value1);
					}
					if( $key == $key1 ) {
						if((ereg("category[12345]",$key) || $key == 'producer')) {
							if(!empty($value1)) {
								$max=$category->check_category($key,$value1);
								$data = $data+array($key=>$value1);
								$data = $data+array("id_".$key=>$max);
							} else {
								$data = $data+array($key=>$value1);
								$data = $data+array("id_".$key=>0);
							}
						} elseif($key == 'price_brutto') {
	                          $value1=ereg_replace(",",".",$value1);
                              $data = $data+array($key=>$value1);
                        } elseif($key == 'price_brutto_2') {
                              $value1=ereg_replace(",",".",$value1);
                              $data = $data+array($key=>$value1);
                        } elseif($value1 == 'auto') {
								$file=$path_file."/".$this->record_hash['user_id']."_".$key.".txt";
								// jesli plik jest i da sie go otworzyc to aktualizuj
								if(file_exists($file)) {
									if($fp=fopen($file,"r")) {
										$content=fread($fp,filesize($file));
										$data = $data+array($key=>$content);
									} else {
									   $this->error_add=5;
									   $error->write_other($lang->offline_file_errors['not_open'].$file);
									}
									fclose($fp);
								} else {
									$this->error_add=5;
									$error->write_other($lang->offline_file_errors['error_file'].$file);
								}
						} else {
							$data = $data+array($key=>$value1);
						}
					}
				}
			}
		}
		$p=& $data;
		//$data = $data+array('active'=>1,'main_page'=>1);
		//print "<pre>";
		//print_r($data);
		//print "</pre>";
		return $p;
	} // end prepare_data
	
   /**
	* Funkcja load_compute oblicza limit produktow do zaladowania
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
	function load_compute() {
		global $database;
		global $db;
		if($this->offline_mode == 'new') {
			$count_product=0;
		} elseif($this->offline_mode == 'update' || $this->offline_mode == 'continue' ) {
			$db->soteSetModSQLOff();
			$count_product=$database->sql_select("count(*)","main");
			$db->soteSetModSQLOn();
		}
		return $count_product;
	} // end load_compute
	
   /**
	* Funkcja aktualizujaca rekord w bazie danych
	*
	* @return boolean true/false
	*
	* @author rdiak@sote.pl
	*/
	function update_data() {
		global $database;
		//print "Updating......";
		
		$data=$this->prepare_data();
		$key=$this->record_hash[$this->field_sql];
		$exist_key=$database->sql_select("count(*)",$this->table,"$this->field_sql=$key");
		if($exist_key > 0 ) {
			$result=$database->sql_update($this->table,"$this->field_sql=$key",$data);
			$this->record_update++;
			return true;
		} else {
			$result=$this->insert_data();
			if($result == 0 ) return false;
			$this->count_record++;
			return true;
		}
	} // end update_data
	
	/**
	* Funkcja insertujaca rekord do bazy danych
	*
	* @return boolean true/false
	*
	* @author       rdiak@sote.pl
	*/
	function insert_data() {
		global $database;
		
		$data=$this->prepare_data();
		$key=$this->record_hash[$this->field_sql];
		$exist_key=$database->sql_select("count(*)",$this->table,"$this->field_sql=$key");
		if($exist_key > 0 ) {
			$database->sql_delete($this->table,"$this->field_sql=$key");
		}		
		$result=$database->sql_insert($this->table,$data);
		if($result == 0 ) return false;

		$this->record_add++;
		return true;
	} // end insert_data
	
   /**
	* Funkcja kasujaca rekord z bazy danych
	*
	* @return boolean true/false
	*
	* @author       rdiak@sote.pl
	*/
	function delete_data() {
		global $error;		
		global $database;
		global $lang;
		
		$key=$this->record_hash[$this->field_sql];
		$exist_key=$database->sql_select("count(*)",$this->table,"$this->field_sql=$key");
		if($exist_key > 0 ) {
			$result=$database->sql_delete($this->table,"$this->field_sql=$key");
			if($result == 0 ) return false;
			$this->record_delete++;
			return true;
		} else {
			$error->write_other($lang->offline_file_errors['no_record'],$this->number);
			return false;
		}
	} // end delete_data

	
   /**
	* Jeden produkt w kilku katagoriach
	*
	* @return boolean true/false
	*
	* @author       rdiak@sote.pl
	*/
	function update_multi(&$record) {
		global $database;
		$data=array();
		// znajdujemy w tablicy wszystkie pola category_multi 
		foreach($this->struct as $key1=>$value1) {
			if(eregi("category_multi",$key1)) {
				array_push($data,$key1);
			}
		}
		$keys=array_keys($this->struct);
		$id_cat=array_search($this->field_sql,$keys);
		foreach($record as $key=>$value) {
			// wyciagamy z tablicy main wszystkie pola definiowane przez zmienna $data
			$data1=$database->sql_select_multi_array5($data,"main","$this->field_sql=$value[$id_cat]");
			$multi=array();
			foreach($data1 as $key1=>$value1) {
				if(!empty($value1)) {
					$id_cat1=MainCategory::getIDCategory($value1);
					$key1="id_".$key1;
					$multi=$multi+array($key1=>$id_cat1);
				}				
			}	
			if(!empty($multi)) {
				$database->sql_update("main","$this->field_sql=$value[$id_cat]",$multi);
			}	
		}		
		return true;
	} // end update_multi
} //end class OfflineLoad
?>
