<?php
/**
 * Obsluga kluczy kodowania users w tableli users_keys
 *
 * @author  m@sote.pl
 * @version $Id: keys.inc.php,v 2.3 2004/12/20 18:01:54 maroslaw Exp $
* @package    users
 */

if (@$__secure_test!=true) die ("Forbidden");

class UsersKeys {
    /**
     * Odczytaj klucz kodowania danych klienta
     * @deprecated since 3.0
     */
    function get_user_key($id_user) {                
        return;
    } // end get_user_key()

} // end class UsersKeys

?>
