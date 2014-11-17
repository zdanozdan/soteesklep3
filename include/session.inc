<?php
/**
 * Obsluga sesji, inicjaja nowej sesji, ustawienie odpowiednich zmiennych sesji
 *
 * @author  m@sote.pl
 * @version $Id: session.inc,v 2.17 2005/08/02 11:15:07 maroslaw Exp $
 * @package soteesklep
 */


// utworz/otworz sesje
if (@$config->google_active!=1) {
    session_name("sess_id");
    $sess_dir="$DOCUMENT_ROOT/../sessions/$config->salt";
    if (! is_dir($sess_dir)) {
        $sess_dir="$DOCUMENT_ROOT/../sessions/12345678901234567890123456789012";
    }
    session_save_path($sess_dir);
    session_start();
    $session_id=session_id();

    // start anty spoofing: || new session registered
    if ((! @empty($_SESSION['REMOTE_ADDR']))  || (@$_SESSION['start_new_session']==1)) {
        if (($_SERVER['REMOTE_ADDR']!=@$_SESSION['REMOTE_ADDR']) && (empty($_POST['p24_session_id']))) {
           // setcookie("sess_id","",time(),"/");
           // header ("Location: http://".$_SERVER['HTTP_HOST'].$config->url_prefix);

//print "<h1>Przerwa techniczna. Prosze sprobowac pozniej. Pracujemy nad usunieciem awarii</h1>";

//		print (!@empty($_SESSION['REMOTE_ADDR']));
//		print $_SERVER['REMOTE_ADDR'];
//		print '--';
//		print $_SESSION['REMOTE_ADDR'];

           // exit;
        }
    }
    // end anty spoofing:

    class MySession {
        var $id; // ID sesji
        var $param="sess_id";        // parametr przekazujacy wartosc sesji przez GET/POST
        var $data=array();           // dane w sesji

        /**
     * Zarejestruj zmienna w sesji, nadpisz wartosc zapisana w sesji 
     *
     * @param unknown $var rejestrowana zmianna
     * @param addr &$value wskaznik wartosci zmiennej $$var
     *
     * @access public
     * @return none
     */
        function register($var,&$value) {
            global $_SESSION;
            global $$var;

            $$var=&$value;
            //session_unregister($var);
            //session_register($var);

            // udostepniej zmienna w pzrestrzeni zmeinnych sesji zaraz po zapisaniu
            // (domyslnie zmienna ta pojawia sie tam dopiero po kolejnym wywolaniu striny)
            $_SESSION[$var]=$value;

            // zapamietaj zmienna w zmiennej klasy
            $this->data[$var]=&$value;

            return(0);
        } // end register()

        /**
     * Wyrejstruj zmienna z sesji
     *
     * @param string $var nazwa zmiennej
     *
     * @access public
     * @return none
     */ 
        function unregister($var) {
            global $_SESSION;

            //session_unregister($var);
            if (! empty($_SESSION[$var])) unset($_SESSION[$var]);
            if (! empty($this->data[$var])) unset ($this->data[$var]);

            return(0);
        } // end unregister()

        /**
     * Sprawdz czy nie przladowano strony
     *
     * @return bool true - wywolano reload, false w p.w.
     * @access public
     */ 
        function reload(){
            global $global_prev_request_md5, $global_request_md5;
            $reload=false;
            if (! empty($global_prev_request_md5)) {
                if ($global_prev_request_md5==$global_request_md5) {
                    // np. jezeli wywolano reload w koszyku, zapamietaj zeby nie dodawac produktu
                    $reload=true;
                }
            }
            return $reload;
        } // end reload()


    } // end class MySession

    $sess =& new MySession;
    $sess->id=$session_id;
    $shop->sess=&$sess;       // przypisz do glownego obiektu sklepu adres obiektu sesji

    // start anty spoofing:
    if (empty($_SESSION['REMOTE_ADDR'])){
        $REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
        $sess->register("REMOTE_ADDR",$REMOTE_ADDR);
    }
    // end anty spoofing:
} else {
    require_once ("include/no_session.inc");
    $session_id=1;
    ini_set("session.use_trans_sid",0);    
    ini_set("session.auto_start",0);    
}

?>
