<?php
/**
* Obsluga systemu lojalnosciowego PayBack.pl
*
* @author  m@sote.pl
* @version $Id: payback_sote.inc.php,v 1.2 2004/12/20 18:03:00 maroslaw Exp $
*
* \@session payback dane o uzytkwoniku i pubktach dot. biezacej sesji zakupow
* @package    include
*/

global $payback_config;
require_once ("config/auto_config/payback_config.inc.php");    
require_once ("include/payback/payback.inc.php");

class PayBack {    

    /**
    * Konstruktor
    */
    function PayBack() {
        global $shop,$payback_config,$sess,$_SESSION;

        $this->shop=&$shop;
        $this->sess=&$sess;
        if (! empty($_SESSION['payback'])) {
            $this->payback=&$_SESSION['payback'];
        }           
                
        return;
    } // end PayBack   
    
    /**
    * Oblicz ile pubktow nadac do danego zamowienia
    *
    * @return int liczba punktow do zamowienia
    * @access public
    */
    function calcPoints() {
	global $payback_config;
        $this->shop->basket();
        $amount=$this->shop->basket->amount();        
        $points=intval(($amount/100)*$payback_config->points);        
        return $points;
    } // end givePoints()
   
    /**
    * Zarejestruj usere w sesji
    *
    * @param string $user nazwa usera payback
    *
    * @access public
    * @return void    
    */   
    function register($user='') {
        global $payback;
        if (empty($user)) return false;
        $payback=array("user"=>$user,"points"=>$this->calcPoints());
        $this->sess->register("payback",$payback);
        return;
    } // end register()

    /**
    * Czy user payback jest w sesji?
    *
    * @access public
    * @return bool   true uzytkownik podal login payback, false w p.w.
    */
    function is() {
        global $_SESSION;
        if (! empty($_SESSION['payback']['user'])) return true;
        else return false;
    } // end is()
    
    /**
    * Nadaj punkty uzytkownikowi (jesli user paybacku jest zarejestrowany w sesji)
    */
    function givePoints() {
        if ($this->is()) {
            // ponizsza funkcja jest dostarczona przez PayBack
            // pb_give_points($this->getPaybackLogin(),$this->calcPoints(),$_SESSION['global_order_id']);
        } else return false;
    } // end givePoints()
    
    /**
    * Odczytaj nazwe uzytkownika PayBack
    *
    * @access public
    * @return string nazwa usera paybacku w danej sesji
    */
    function getPaybackLogin() {
        global $_SESSION;
        if ($this->is()) {
            return $_SESSION['payback']['user'];
        } else return '';
    } // end getPayBackLogin()
    
} // end class PayBack
?>
