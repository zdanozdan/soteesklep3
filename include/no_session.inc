<?php
/**
 * Emulacja klasy obslugi sesji
 * 
 * @author m@sote.pl
 * @version $Id: no_session.inc,v 2.2 2003/11/09 08:07:17 maroslaw Exp $
 * @package soteesklep
 */

class MySession {
    var $id; // ID sesji
    var $param="sess_id";
    
    /**
     * Zarejestruj zmienna w sesji, nadpisz wartosc zapisana w sesji 
     *
     * @param unknown $var rejestrowana zmianna
     * @param addr &$value wskaznik wartosci zmiennej $$var
     */
    function register($var,&$value) {
        return;
    } // end register()
    
    /**
     * Wyrejstruj zmienna z sesji
     */ 
    function unregister($var) {
        return;
    } // end unregister()

} // end class MySession

$sess = new MySession;
if (! empty($_REQUEST['sess_id'])) {
    $sess->id=$_REQUEST['sess_id'];
} elseif (! empty($_POST['sess_id'])) {
    $sess->id=$_POST['sess_id'];
} else $sess->id='';

?>
