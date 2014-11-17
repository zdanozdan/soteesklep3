<?php
/**
 * PHP Template
 * 
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author m@sote.pl
 * @version $Id: form_check_functions.inc.php,v 1.2 2004/12/20 18:00:49 maroslaw Exp $
 * @return int $this->id
* @package    reviews
* @subpackage scores
 */

class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
    
    /**
     * Sprawdzenie score_amount i scores_number - suma ocen i liczba ocen
     *
     * @author piotrek@sote.pl
     * @param  $score string - suma lub liczba ocen
     *
     * @public
     */
        
    function scores($score) {
        
        if(empty($score)) {
            $this->error_nr=10;   // wpisz warto¶æ         
            return false;
        }
        
        if (! eregi("^[0-9]+$",$score)) {            
            $this->error_nr=11;   // zla wartosc         
            return false;
        }
        
        return true;
    }
    
} // end class FormCheckFunction
?>
