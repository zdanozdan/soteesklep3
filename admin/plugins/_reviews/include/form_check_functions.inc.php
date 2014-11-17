<?php
/**
 * PHP Template
 * 
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author piotrek@sote.pl
 * @version $Id: form_check_functions.inc.php,v 1.6 2004/12/20 18:00:51 maroslaw Exp $
 * @return int $this->id
* @package    reviews
 */

require_once ("include/metabase.inc");

class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
    
    /**
     * Sprawdzenie user_id - identyfikator produktu zdefiniowany przez uzytkownika
     *
     * @author piotrek@sote.pl
     * @param  $user_id string - identyfikator produktu
     *
     * @public
     */
    function user_id($user_id) {
        
        global $database;
        
        if (empty($user_id)) {
            $this->error_nr=10;   // podaj identyfikator         
            return false;
        }
        
        $id=$database->sql_select("id","main","user_id=$user_id");
        if (empty($id)) {
            $this->error_nr=12;   // takiego produktu nie ma w bazie danych wybierz inny
            return false;
        }
        
        return true;
    }
    
} // end class FormCheckFunction
?>
