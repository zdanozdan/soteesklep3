<?php
/**
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author  m@sote.pl
 * \@template_version Id: form_check_functions.inc.php,v 2.3 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: form_check_functions.inc.php,v 1.2 2004/12/20 18:00:45 maroslaw Exp $
 * @return  int $this->id
* @package    promotions
 */
class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sprawdzajacych poprawnosc pol formularza
    
    /**
     * Sprawdz rabat
    *
    * @param float $discount rabat %
    *
    * @access public
    * @return bool true - wartosc poprawna69, false w p.w.
    */
    function discount($discount) {
        if (($discount>0) && ($discount<100)) return true;
        return false;   
    } // end dicount()
    
} // end class FormCheckFunctions
?>
