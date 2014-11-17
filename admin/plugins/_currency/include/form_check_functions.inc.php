<?php
/**
 * PHP Template
 * 
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author  m@sote.pl
 * @version $Id: form_check_functions.inc.php,v 2.1 2006/02/13 14:17:38 maroslaw Exp $ 
 * @package currency
 */

/**
* @package currency
*/
class FormCheckFunctions extends FormCheck {
    
    /**
    * Sprawdzenie poprawno¶ci pola name - nazwy waluty
    *
    * @param string $name 
    * @return bool
    */
    function currency_name($name) {
        global $mdbd;
        
        $ret=$this->string($name);
        if (! $ret) return $ret;
        
        $currency_name=$mdbd->select("currency_name","currency","currency_name=?",array($name=>"text"),"LIMIT 1");
        if (empty($currency_name)) return true;
        else return false;        
    } // end currency_name()
    
} // end class FormCheckFunctions
?>
