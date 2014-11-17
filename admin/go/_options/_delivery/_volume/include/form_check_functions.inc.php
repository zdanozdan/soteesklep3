<?php
/**
 * PHP Template
 *
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author piotrek@sote.pl
 * @version $Id: form_check_functions.inc.php,v 1.5 2005/04/22 10:55:55 scalak Exp $
 * @package soteesklep reviews
 * @return int $this->id
 */

require_once ("include/form_check.inc");

class FormCheckFunctions extends FormCheck {
	
	function range_max($val) {
		global $mdbd;
		global $_REQUEST;

		if (! ereg("^[0-9]+$",$val)) {
			$this->error_nr=1;
			return false;
		}
		if (! ereg("^[0-9]+$",$_REQUEST['id'])) {
			$this->error_nr=1;
			return false;
		} 
		$id=$_REQUEST['id'];	
		
		// wyciagany cala tablice delivery_volume tablicy php
		$del_vol=$mdbd->select("id,range_max","delivery_volume","1=1","","ORDER BY range_max","array");
		// stara wartosc ktora zmieniamy
		$old_vol=$mdbd->select("range_max","delivery_volume","id=$id","","","auto");
		
		// sprawdzamy ile mamy drefiniowany zakresow objetosci
		$count=count($del_vol);
		for($i=0;$i<$count;$i++) {
			// znalezlismy element ktory chcemy modfyfikowac			
			if($del_vol[$i]['range_max'] == $old_vol) {
				// teraz musimy sprawdzic czy to co chcemy wpisac nie jest wieksze
				// od elementów sasiednich
				if(isset($del_vol[$i+1]['range_max'])) {
					if($del_vol[$i+1]['range_max'] <= $val) {
						$this->error_nr=1;
						return false;
					}
				}
				if(isset($del_vol[$i-1]['range_max'])) {
					if($del_vol[$i-1]['range_max'] >= $val) {
						$this->error_nr=1;
						return false;
					}
				}
				break;
			}
		}
		return true;
	} // end range_max

	function range_max_add($val) {
		global $mdbd;
		global $_REQUEST;

		if (! ereg("^[0-9]+$",$val)) {
			$this->error_nr=1;
			return false;
		}
		// wyciagany cala tablice delivery_volume tablicy php
		$del_vol=$mdbd->select("max(range_max)","delivery_volume","1=1","","ORDER BY range_max","");
		// sprawdzamy ile mamy drefiniowany zakresow objetosci
		if($val <= $del_vol[0]['max(range_max)']) {
			$this->error_nr=1;
			return false;
		}
		return true;
	} // end range_max
} // end class FormCheckFunction
?>
