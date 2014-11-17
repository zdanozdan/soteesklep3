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
* Klasa z funkcjami weryfikuj�cymi dane dot. pin�w.
*
* @package admin_users
* @subpackage pin
*/
class FormPinFunctions extends FormCheck {
    
    /**
    * Sprawd�, czy poprawny jest aktualny PIN.
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
    * Sprawdzenie jest pomini�te, ale mo�na rozszerzy� to w przysz�os�i. Obecnie system zapami�tuje
    * wprowadzon� warto�� do por�wnania powt�rzenia PINu.
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
    * Sprawd�, czy poprawnie wprowadzono potwierdzenie PIN.
    *
    * @param string $new2 PIN - powt�rzenie
    * @return bool
    */
    function f_new2($new2) {
        if (@$this->new==$new2) return true;
        return false;
    } // end f_new2()
    
} // end class FormPinFunctions
?>
