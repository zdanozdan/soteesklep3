<?php
/**
* Weryfikacja danych formularza.
*
* @author  m@sote.pl
* @version $Id: FormPinFunctions.inc.php,v 2.2 2004/12/20 17:57:50 maroslaw Exp $
* @package    admin_users
* @subpackage pin
*/

/**
* Klasa z funkcjami weryfikuj±cymi dane dot. pinów.
*
* @package admin_users
* @subpackage pin
*/
class FormPinFunctions extends FormCheck {
    
    /**
    * Sprawd¼, czy poprawny jest aktualny PIN.
    *
    * @param string $pin PIN
    * @return bool
    */
    function f_pin($pin) {
        global $config;
        if (md5($pin)==$config->md5_pin)
        return true;
        return false;
    } // end f_pin()
    
    /**
    * Sprawdzenie nowego wprowadzonego PINu.
    * Sprawdzenie jest pominiête, ale mo¿na rozszerzyæ to w przysz³osæi. Obecnie system zapamiêtuje
    * wprowadzon± warto¶æ do porównania powtórzenia PINu.
    *
    * @param string $new PIN
    * @return bool
    */
    function f_new($new) {
        if (! empty($new)){
            $this->new=$new;
            return true;
        } else return false;
    } // end d_new()
    
    /**
    * Sprawd¼, czy poprawnie wprowadzono potwierdzenie PIN.
    *
    * @param string $new2 PIN - powtórzenie
    * @return bool
    */
    function f_new2($new2) {
        if (@$this->new==$new2) return true;
        return false;
    } // end f_new2()
    
} // end class FormPinFunctions
?>
