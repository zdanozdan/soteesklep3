<?php
/**
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author rdiak@sote.pl
 * @version $Id: form_check_functions.inc.php,v 1.1 2005/12/22 11:41:23 scalak Exp $
* @package    offline
* @subpackage main
 */

/**
* Includowanie klasy bazowej do formcheck
*/
require_once ("include/form_check.inc");

/**
 * Klasa FormCheckFunctions
 *
 * @package offline
 * @subpackage admin
 */
class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sprawdzajacych poprawnosc pol formularza
    function command($val) {
        if (ereg("^[ADUadu]$",$val) || empty($val)) {
            return true;
        } else {
            $this->error_nr=2;
        	return false;
        }    
    }   // end command

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
    } // end photo
  
    function int_null($val) {
        if (ereg("^[0-9]$",$val) || $val=='') {
            return true;
        } else {
            $this->error_nr=1;
            return false;
        }
        return true;
    } // end int_null
    function id_deliverer($val) 
    {
        global $deliverers;
        foreach($deliverers as $key=>$value) {
            if($val == $value) return true;
        }
        return false;
    }
    /**
    * Dowolny ciag znakow
    *
    * @param string $val wartosc pola
    * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
    */
    function string($val) {
        global $database;
        
        $count=$database->sql_select("count(*)","main","user_id=".$val);
        if(!$count) return false;
        
        if (! empty($val)) {
            if (strlen($val)>$this->max_string) {
                $this->error_nr=1;
                return false;
            } else return true;
        }
        $this->error_nr=0;
        return false;
    } // end string()
    
} // end class FormCheckFunction
?>
