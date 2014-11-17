<?php
/**
 * Obsluga logowania i wylogowywania uzytkownikow. Klasa dostepne globalnie.
* @version    $Id: login.inc,v 2.3 2004/12/20 18:02:53 maroslaw Exp $
* @package    include
 */
class SysLogin {
    var $login;           // nazwa uzytkwonika

    /**
     * Czy uzytkownik jest zalogowany w systemie
     * @return bool 
     */
    function is_login() {
        global $_SESSION;
        global $global_login,$global_prv_key;

        if ((! empty($_SESSION['global_login'])) && (! empty($_SESSION['global_prv_key'])))
            return true;
        if ((! empty($global_login)) && (! empty($global_prv_key))) 
            return true;
        return false;
    } // end is_registered()

    /**
     * Jesli user jest zalogowany w sytemie to pokaz link do wylogowania, w przeciwnym wypadku
     * Wstaw formularz lgogowania
     */
    function login_form() {
        global $theme;
        global $DOCUMENT_ROOT;
        global $lang;
        
        if ($this->is_login()) {
            // uzytkwonik jest zalogowany
            
            //dolacz menu dla panelu uzytkownika
            //include_once("./include/menu.inc.php"); 
            //naglowek panelu uzytkownika
            //$theme->bar($lang->users_bar);
            $theme->theme_file("login_logout.html.php");
        } else {
            $theme->theme_file("login_form.html.php");
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

$sys_login = new SysLogin;
?>
