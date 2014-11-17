<?php
/**
 * PHP Template
 *
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author piotrek@sote.pl
 * @version $Id: form_check_functions.inc.php,v 1.2 2004/12/20 17:58:34 maroslaw Exp $
 * @return int $this->id
* @package    offline
* @subpackage main_keys
 */

require_once ("include/form_check.inc");

class FormCheckFunctions extends FormCheck {
	function nominal($val) {
		global $load;
		if($val == $load->money_mode) {
			return true;
		} else {
			return false;
		}
	}
	function pin($val) {
		if (! ereg("^[0-9]+$",$val)) {
			$this->error_nr=1;
			return false;
		}
		if (strlen($val) < 12) {
			$this->error_nr=2;
			return false;
		}
		if (strlen($val) > 12) {
			$this->error_nr=3;
			return false;
		}
		return true;
	}

	// lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
    function command($val) {
        if(empty($val)) {
            $this->error_nr=1;
            return false;
        }
        if (! ereg("^[ADUadu]$",$val)) {
            $this->error_nr=2;
            return false;
        }
        return true;
    }

    function photo($val) {
        if(empty($val)) {
            $this->error_nr=1;
            return false;
        }
        if (ereg("[_A-Za-z0-9-]+\.[png|PNG|gif|GIF|jpg|JPG|jpeg|JPEG]",$val)) {
            return true;
        } else {
            $this->error_nr=2;
            return false;
        }
        return true;
    }
  
    function int_null($val) {
        if (ereg("^[0-9]$",$val) || $val=='') {
            return true;
        } else {
            $this->error_nr=1;
            return false;
        }
        return true;
    }


} // end class FormCheckFunction
?>
