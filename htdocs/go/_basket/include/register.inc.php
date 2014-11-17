<?php
/**
 * Formularze i obsluga formularzy zamowienia 
* @version    $Id: register.inc.php,v 2.3 2006/02/09 10:34:39 maroslaw Exp $
* @package    basket
 */

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($global_secure_test)) || (! empty($_REQUEST['global_secure_test']))) {    
    die ("Niedozwolone wywolanie");
}

/**
* Wy¶wietl formularz z danymi bilingowymi.
*
* @package basket
*/
class Register {
    function billing_form() {
        $theme->register_billing_form();
        return;
    }
}

?>
