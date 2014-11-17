<?php
/**
 * Obsluga logowania i wylogowywania uzytkownikow. Klasa dostepne globalnie.
* @version    $Id: firm_login.inc,v 2.2 2004/12/20 18:02:52 maroslaw Exp $
* @package    include
 */
class FirmLogin {

    /**
     * Czy uzytkownik jest zalogowany w systemie
     * @return bool 
     */
    function is_login() {
        global $_SESSION;
        global $global_firm_login;

        if (! empty($_SESSION['global_firm_login'])) {
            return true;
        }
        if (! empty($global_firm_login)) {
            return true;
        }
        return false;
    } // end is_registered()

    /**
     * Jesli user jest zalogowany w sytemie to pokaz link do wylogowania, w przeciwnym wypadku
     * Wstaw formularz lgogowania
     */
    function login_form() {
        global $theme;

        if ($this->is_login()) {
            /// uzytkwonik jest zalogowany
            $theme->theme_file("_firm/firm_logout.html.php");
        } else {            
            $theme->theme_file("_firm/firm_login_form.html.php");
        }
        return;
    } // end login_form()

    /**
     * Wyloguj biezacego uzytkownika
     */
    function logout() {
        return;
    } // end logout()

} // end clas SysLogin

$f_login = new FirmLogin;

?>
