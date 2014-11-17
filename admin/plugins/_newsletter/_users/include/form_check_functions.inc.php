<?php
/**
* Sprawdz poprawnosc formularza, dodatkowe funkcje
*
* @author  rdiak@sote.pl
* template_version Id: form_check_functions.inc.php,v 1.1 2003/02/26 11:34:50 maroslaw Exp
* @version $Id: form_check_functions.inc.php,v 2.6 2004/12/20 18:00:19 maroslaw Exp $
*
* verified 2004-03-28 m@sote.pl
* @package    newsletter
* @subpackage users
*/

/**
* @todo uzyæ fukcji walidacji e-mail bazuj±cej na funkcji z klasy PEAR/Validate/Validate.php
* @todo dodac opis funkcji alias1()
*/

require_once("include/metabase.inc");

/**
* Klasa z funkcjami sprawdzaj±cymi poprawno¶ci pól formularza dodania/modyfikacji adresu e-mail.
* @package newsletter
* @subpackage users
*/
class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
    /**
    * Sprawdz pole alias
    *
    * @param string $alias alias - email
    * @return bool true - pole poparwnie wypelnione, false - zle
    */
    function alias($email) {
        global $database;
        
        // tu sprawdzamy czy alias nie jest pusty, mozemy sprawdzic pioprawnosc formatum, zgodnosc z domena
        // oraz czy taki alias juz istnieje w systemie, w bazie dnaych
        // jesli wszystko ejst ok zwracamy true, else false
        if (empty($email)) {
            $this->error_nr=10;
            return false;
        }
        if (!eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$", $email)){
            $this->error_nr=11;
            return false;
        }
        $id=$database->sql_select("id","newsletter","email=$email");
        if (! empty($id)) {
            $this->error_nr=12;
            return false;
        }
        return true;
    } // end alias()
    
    function alias1($email) {
        global $database;
        
        // tu sprawdzamy czy alias nie jest pusty, mozemy sprawdzic pioprawnosc formatum, zgodnosc z domena
        // oraz czy taki alias juz istnieje w systemie, w bazie dnaych
        // jesli wszystko ejst ok zwracamy true, else false
        if (empty($email)) {
            $this->error_nr=10;
            return false;
        }
        if (!eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$", $email)){
            $this->error_nr=11;
            return false;
        }
        return true;
    } // end alias1()
    
} // end class FormCheckFunctions
?>
