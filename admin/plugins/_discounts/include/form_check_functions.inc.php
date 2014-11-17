<?php
/**
 * PHP Template
 * 
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author m@sote.pl
 * \@template_version Id: form_check_functions.inc.php,v 1.1 2003/02/26 11:34:50 maroslaw Exp
 * @version $Id: form_check_functions.inc.php,v 2.3 2004/12/20 17:59:45 maroslaw Exp $
 * @return int $this->id
* @package    discounts
 */

class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
    
    function discount(&$val) {
        $val=number_format($val,4,".","");
        if (ereg("^[0-9\.]+$",$val)) 
            if (($val>=0) && ($val<=100)) 
                return true;
        return false;
    }
} // end class FormCheckFunctions
?>
