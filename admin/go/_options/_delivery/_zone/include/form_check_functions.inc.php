<?php
/**
 * PHP Template
 *
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author piotrek@sote.pl
 * @version $Id: form_check_functions.inc.php,v 1.3 2005/02/24 14:00:43 scalak Exp $
 * @package soteesklep reviews
 * @return int $this->id
 */

require_once ("include/form_check.inc");

class FormCheckFunctions extends FormCheck {

    /**
	 * Funkcja sprawdza czy jeden kraj nie znajduje sie w kilku strefach dostawy 
     * 
     * @param  array $val kraje ktore chcemy dodac do strefy 
     * @return bool   
     *
     * @access public
     */
	function check_country($val) {
		global $mdbd;
		global $country_error;
		global $_REQUEST;

		if (!ereg("[0-9]+",$_REQUEST['id'])) {
			$_REQUEST['id']=1;
		}	
		$id_zone=$_REQUEST['id'];
		if(!empty($val)) {
			foreach($val as $key=>$value) {
				$country_error=array();
				$where=" country LIKE '%".$value."%' AND (id!=1 AND id!=12 AND id!=".$id_zone.") ";
				$count=$mdbd->select("id,name","delivery_zone",$where,"","","array");
				$cnt=count($count);
				if(!empty($count)) {
					foreach($count as $key1=>$value1) {
						$count[$key1]=$count[$key1]+array("country"=>$value);
					}	
					$country_error=$count;
					$this->error_nr=1;
					return false;
				}	
			}
		} 
		return true;
	} // end func check_country

    /**
	 * Funkcja sprawdza czy nazwa stefy sie nie powtarza  
     * 
     * @param  string $val nazwa strefy
     * @return bool   
     *
     * @access public
     */
	function check_name($val) {
		global $mdbd;
		global $_REQUEST;

		if (!ereg("[0-9]+",$_REQUEST['id'])) {
			$_REQUEST['id']=1;
		}	
		$id_zone=$_REQUEST['id'];
		if(!empty($val)) {
				$where=" upper(name)=upper('".$val."') AND (id!=".$id_zone.")";
				$count=$mdbd->select("id,name","delivery_zone",$where,"","","array");
				$cnt=count($count);
				if(!empty($count)) {
					$this->error_nr=1;
					return false;
				}	
		} 
		return true;
	} // end func check_name
} // end class FormCheckFunctions	
?>
