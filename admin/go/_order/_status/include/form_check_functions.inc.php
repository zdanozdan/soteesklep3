<?php
/**
* Dodatkowe funkcje sprawdzajace pola formularza
*
* @author  m@sote.pl
* @version $Id: form_check_functions.inc.php,v 2.2 2004/12/20 17:58:51 maroslaw Exp $
* @package    order
* @subpackage status
*/

/**
* Dodaj klasê obs³ugi validacji formularzy.
*/
require_once ("include/form_check.inc");

/**
* Definicja dodatkowych funkcji validacji danych formularza.
* @package order
* @subpackage status
*/ 
class FormCheckFunctions extends FormCheck {
    
    /**
    * Sprawdz pole user_id
    *
    * @param int $user_id user_id statusu platnosci
    *
    * @access public
    * @return none
    */    
    function user_id($user_id) {
        global $mdbd;
        if (! $this->int($user_id)) return false;
        
        $id=$mdbd->select("id","order_status","user_id=?",array($user_id=>"int"),"LIMIT 1");
        if ($id>0) {
             $this->error_nr=10;
             return false;
        } else return true;
    } // end user_id()
    
} // end class FormCheckFunctions
?>
