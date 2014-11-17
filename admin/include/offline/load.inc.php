<?php
/**
 * Klasa zawierajaca funkcje bezposredniego ladowania danych do bazy danych
 *
 * @author rdiak@sote.pl
 * @version $Id: load.inc.php,v 1.2 2004/12/20 17:59:26 maroslaw Exp $
* @package    admin_include
 */

include_once("include/metabase.inc");
require_once("./include/form_check_functions.inc.php");
require_once("./include/encode.inc.php");
require_once("include/my_crypt.inc");

class OfflineLoad {

    var $mode='';                   // true - sa ladowane wszystkie dane false - dane do okreslonych kolumn
    var $table='';                  // nazwa tablicy do ktorej ladowane sa dane
    var $struct=array();            // zawiera albo stukture tablicy $config->offline_file_struct albo $config->offline_current_columns
    var $count='';                  // ilosc pol w rekordzie ladowanym do bazy danych
    var $struct_database=array();   // struktura tablicy w bazie danych
    var $record_hash=array();       // aktualnie obrabiany rekord w postaci tablicy asoscjancyjnej
    var $field_sql='';              // pole ktore jest uzywane w warunku where sql
    var $offline_mode='';           // tryb pracy offline
    var $count_record='';           // ilosc zaladowanych rekordow
    var $count_limit='';            // ilosc dozwolonych do zaladowania rekordow
    var $record_add=0;
    var $record_update=0;
    var $record_delete=0;
	var $status_filed='';           // czy w rekordzie instnieje pole status o warosciach A U D S
	var $money_mode='';				// o jakim nominale piny sa ladowane
    var $field_code='';

    /**
     * Konstruktor obiektu Load inicjuje zmienne
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    function OfflineLoad() {
        global $config;
        // tymczasowo zdefiniowana zmienna
        global $money_mode;
        $this->mode=$config->offline_load_mode;
        $this->table=$config->offline_table;
        $this->count_limit=hexdec($config->offline_nccp);
        $this->field_sql=$config->offline_field_sql;
        $this->struct_database=$config->offline_types;
        $this->offline_mode="update";
		$this->status_filed=$config->offline_status_field;
		$this->money_mode=$money_mode;
        // jak zostanie opracowany panel do offline to odkomentujemy to
        // $this->offline_mode=$config->offline_mode;
        if($config->offline_load_mode == 'true') {
            $this->struct=$config->offline_file_struct;
        } else {
            $this->struct=$config->offline_current_columns;
        }
        $this->count=count($this->struct);
        $this->count_record=$this->load_compute();
        if($this->offline_mode == 'new') {
            $this->delete_table();
        }
        $this->field_code=$config->offline_code;
		return true;
    }

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
        //print "check......";

        global $error;
        global $lang;

        $data=array();
        $form_check= new FormCheckFunctions;
        $form_check->fun=$this->struct;
		//print_r($this->struct);
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
    }

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
		//print_r($record);
		//print "<br>";
        //print "load record.....";
        if($this->count_record < $this->count_limit) {
            if($this->check_record($record,$number)) {
				if($this->status_filed == 'true') {
					if($record[0] == 'A' || $record[0] == 'a') {
                    	array_shift($this->record_hash);
                        // zakoduj pola ktore tego wymagaja przed wsadzeniem ich do bazy danych
						$this->field_code();
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
                    return 1;
                } else {
                    $error->write_other($lang->offline_file_errors['load_database'],$number);
                    return 3;
                }
            } else {
                return 2;
            }
        } else {
            $error->write_other($lang->offline_file_errors['load_ignore'],$number);
            // rekody nie zaladowane ze wzgledu na ograniczenia 
            return 4;
        }
    } // end func load_record

    /**
     * Funkcja  delete_table kasuje tablice i jest wywolywana wtedy kiedy prametr offline_mode=new
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    function delete_table() {
        global $database;
        $database->sql_delete('category1');
        $database->sql_delete('category2');
        $database->sql_delete('category3');
        $database->sql_delete('category4');
        $database->sql_delete('category5');
        $database->sql_delete('producer');
        $database->sql_delete('main');
        return true;
    }


    /**
     * Funkcja prepare_data tworzy tablica asocajacyjna ktora jest wykorzystywana w funkcjach ladujacych dane do bazy
     *
     * @return int    $data       tablica asocjacyjna
     *
     * @author rdiak@sote.pl
     */

    function prepare_data() {
        global $config;
        global $category;
        global $encode;

        $data=array();
        $my_crypt=new MyCrypt;
        // przechodzimy przez cala tablice $config->offline_relation
        foreach($config->offline_relation as $key => $value) {
            foreach($this->record_hash as $key1 => $value1) {
                $value1=$encode->encoding_win1250_to_8859($value1);
                if( $key == $key1 ) {
                    if(in_array($key,$this->field_code)) {
                        $value1=$my_crypt->endecrypt("",$value1);
                    }
                    if((ereg("category[12345]",$key) || $key == 'producer')) {
		                if(!empty($value1)) {
                            $max=$category->check_category($key,$value1);
                            $data = $data+array($key=>$value1);
                            $data = $data+array("id_".$key=>$max);
		                } else {
                            $data = $data+array($key=>$value1);
                            $data = $data+array("id_".$key=>0);
		                }
                    } else {
                        $data = $data+array($key=>$value1);
                    }
                }
            }
        }
        return $data;
    } // end func prepare_data

    /**
     * Funkcja load_compute oblicza limit produktow do zaladowania
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    function load_compute() {
        global $database;
        if($this->offline_mode == 'new') {
            $count_product=0;
        } elseif($this->offline_mode == 'update' || $this->offline_mode == 'continue' ) {
            $count_product=$database->sql_select("count(*)",$this->table);
        }
        return $count_product;
    } // end func load_compute

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
        $key=$data[$this->field_sql];
        $exist_key=$database->sql_select("count(*)",$this->table,"$this->field_sql=$key");
		if($exist_key > 0 ) {
	  		$result=$database->sql_update($this->table,"$this->field_sql=$key",$data);
	  		$this->record_update++;
	  		return true;
		} else {
	  		return false;
		}
    } // end func update_data

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
        $key=$data[$this->field_sql];
		$exist_key=$database->sql_select("count(*)",$this->table,"$this->field_sql=$key");
		if($exist_key > 0 ) {
	    	  return false;
		} else {
	        $result=$database->sql_insert($this->table,$data);
	        if($result == 0 )
                return false;
	        $this->record_add++;
	        return true;
	    }
    } // end func insert_data

    /**
     * Funkcja kasujaca rekord z bazy danych
     *
     * @return boolean true/false
     *
     * @author       rdiak@sote.pl
     */

    function delete_data() {
        global $database;

        $key=$this->record_hash[$this->field_sql];
		$exist_key=$database->sql_select("count(*)",$this->table,"$this->field_sql=$key");
		if($exist_key > 0 ) {
	    	$result=$database->sql_delete($this->table,"$this->field_sql=$key");
	      	if($result == 0 )
		    	return false;
	      		$this->record_delete++;
	      		return true;
			} else {
	      return false;
		}
    } // end func delete_data

} //end class OfflineLoad

?>
