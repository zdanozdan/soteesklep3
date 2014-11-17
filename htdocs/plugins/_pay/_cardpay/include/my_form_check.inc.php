<?php
/**
* Funckje sprawdzaj±ce poprawno¶æ pól formularza danych karty p³atniczej
*
* @author lukasz@sote.pl
* @version $Id: my_form_check.inc.php,v 1.1 2005/10/26 12:45:27 lukasz Exp $
*
* @package    card_pay
*/
require_once("include/form_check.inc");

class MyFormCheck extends FormCheck {
	var $curr_year=false;
	
	function _is_good_sized_num ($num,$size) {
		if (strlen($num) != $size) return false;
		if (!ereg("^[0-9]{".$size."}$",$num)) return false;
		return true;
	}
	function card ($card_id) {
		$card_id=ereg_replace("-","",$card_id);
		if (!$this->_is_good_sized_num($card_id,16)) return false;
		return true;
	}
	
	function cvv ($cvv) {
		if (!$this->_is_good_sized_num($cvv,3)) return false;
		return true;
	}
	
	function exp_month ($month) {
		if (!$this->_is_good_sized_num($month,2) && !$this->_is_good_sized_num($month,1)) return false;
		$today = getdate();
		$this_month=$today['mon'];
		$this_year=$today['year'];
		if ($this->curr_year) {
			if ($this_month > $month) return false;
		}
		$month=(int)$month;
		if ($month > 12 || $month <1) return false;
		return true;
	}
	
	function exp_year ($year) {
		if (!$this->_is_good_sized_num($year,4)) return false;
		$today = getdate();
		$this_year=$today['year'];
		if ($this_year == $year) $this->curr_year=true;
		if ($this_year > $year) return false;
		return true;
	}
}
?>