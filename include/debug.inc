<?php
/**
 * Obsluga bledow, debugowanie
* @version    $Id: debug.inc,v 2.8 2005/06/08 11:22:42 maroslaw Exp $
* @package    include
 */

@include_once("lang/_$config->lang/error.inc.php");

if (! empty($debug_test)) {

    class Debug extends ErrorAdmin {
        var $errors=array();
        var $last_error=array();

        /**
     * Zapamietaj blad, ktory wystapil
     *
     * @param string $error komunikat o bledzie,
     *                     nazwa zmiennej okreslonej w lang/_xx/error.inc.php
     * @param string $from nazwa elementu ktorego dotyczy komunikat
     * @param int $priority priorytet bledu 
     *                      0 - info
     *                      1 - warning
     *                      2 - error
     *                     <0 - critical: die
     *                      -1   - database error
     *                     <-100 - security error 
     */
        function error($error,$from,$priority) {
            $this->last_error['error']=$this->$error;
            $this->last_error['from']=$from;
            array_push($this->errors,$this->last_error);
            $this->last_error=$this->$error;
            if ($priority<0) {
                die ("<font color=red>$from:".$this->$error."</font>");
            }
            return;
        } // end error()

        /**
     * Dodaj informacje o wykonanej operacji
     *
     * @param strong $info informcaja, nazwa zmiennej okreslonej w lang/_xx/status.inc.php
     * @param string $from nazwa elementu ktorego dotyczy komunikat
     */ 
        function info($info,$from="") {
            $this->last_error['error']=$info;
            $this->last_error['from']=$from;
            array_push($this->errors,$this->last_error);
            return;
        }

        /**
     * Wywietl komunikaty o bledach
     *
     * @return HTML z komunikatami error
     */
        function get_errors() {
            $o="";
            foreach ($this->errors as $error) {
                $o.="<font color=red>".$error['from'].":".$error['error']."</font><BR>";
            }
            return $o;
        } // end show_errors()
    } // end class Debug

    $debug = new Debug;
}
?>
