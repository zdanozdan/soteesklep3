<?php
/**
 * Odczytywanie danych z formatu DBF i przwtworzenie go na format tablicy PHP
 *
 * @author  
 * @version $Id: dbf.inc.php,v 1.1 2005/04/21 07:12:07 scalak Exp $
* @package    offline
* @subpackage main
 */


/**
 * Klasa OfflineDBF
 *
 * @package offline
 * @subpackage admin
 */

include_once("./include/dbfclass.inc.php");

class OfflineDBF {

	var $filename='';                 // nazwa pliku ktory jest ladowany
	var $record=array();              // tablica ktora bedzie zawierac przetworzone rekordy

		
	
	function OfflineDBF () {
		global $config;
		global $DOCUMENT_ROOT;

		//$this->filename=$config->offline_filename;
		$this->filename=$DOCUMENT_ROOT."/tmp/MAGAZ.DBF";//WARNING !!! CASE SENSITIVE APPLIED !!!!!
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
		$dbf = new dbf_class($this->filename);
		//pobierz liczbe rekordów	
		$num_rec=$dbf->dbf_rec_size;
		// ile jest pol w rekordzie
		$field_num=$dbf->dbf_field_size;
		$arrRec =  $dbf->dbf_record;
		$arrField = $dbf->dbf_field;

		
		for($i=0; $i<$num_rec; $i++){
				$table=array(
								$arrRec[$i]['NAZWA_ART'],
								$arrRec[$i]['NR_HANDL'],
								$arrRec[$i]['CENA_AX'],
								$arrRec[$i]['STAWKA_VAT'],
								$arrRec[$i]['K_NAZWA'],
							);
     			array_push($this->record,$table);
		}	
		return $this->record;
	}
} // end class OfflineDBF

/**
 * Klasa Parser
 *
 * @package offline
 * @subpackage admin
 * @ignore Parser
 */
class Parser extends OfflineDBF {}
?>
