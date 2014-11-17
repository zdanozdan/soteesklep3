<?php
/**
* Generowanie struktury obiektow SOTEeSKLEP
*
* @author  m@sote.pl
* @version $Id: objects.inc,v 2.19 2006/01/25 13:28:50 lukasz Exp $
* @package    include
*/

class SOTEeSKLEP {
    
    var $mail;             // obiekt mail
    var $basket;           // obiekt masket (my_basket)
    var $currency;         // obiekt Currency (obsluga walut)
    var $global;           // tablica zmiennych globalnych
    var $request=array();  // tablica $_REQUEST
    var $post=array();     // tablica $_POST
    var $get=array();      // tablica $_GET
    var $server=array();   // tablica $_SERVER
    
    /**
    * @var bool true - dla instalacji na home.pl dla IdeaWebServer
    */
    var $home=false;
    
    /**
    * @var bool true - wywolany jest panel administratora sklepu
    */
    var $admin=false;
    
    /**
    * Konstruktor
    */
    function SOTEeSKLEP() {
        global $DOCUMENT_ROOT,$GLOBALS,$_SERVER;
        
        if (ereg("^IdeaWebServer",$_SERVER['SERVER_SOFTWARE'])) {
            $this->home=true;
            if (ereg("admin.",$_SERVER['HTTP_HOST'])) {
                $this->admin=true;
            }
        } else {            
            if ((ereg("admin$",$DOCUMENT_ROOT)) || (ereg("admin",$_SERVER['HTTP_HOST']))) $this->admin=true;
        }
        $this->global=&$GLOBALS;
        if (! empty($_REQUEST)) $this->request=&$_REQUEST;
        if (! empty($_POST)) $this->post=&$_POST;
        if (! empty($_GET)) $this->get=&$_GET;
        if (! empty($_SERVER)) $this->server=&$_SERVER;
        
        return (0);
    } // end SOTEeSKLEP()
    
    /**
    * Mail init
    */
    function mail() {
        if (empty($this->mail)) {
            require_once ("lib/Mail/MyMail.php");
            $this->mail =& new MyMail;
        }
        return(0);
    } // end mail()
    
    /**
    * Basket init
    *
    * \@global object $this->basket
    *
    * @access public
    * @return none
    */
    function basket() {
        global $my_basket;
        global $DOCUMENT_ROOT;
        // if ((empty($my_basket)) && (empty($this->basket))) {
        // wyhaszowane, gdyz po powrocie z mbank pokazywal error
        // i klasa basket nie byla dostepna, warunke empty($this->basket)
        // nie byl spelniony
        // z debugowania wynika, ze funkcja $this->basket() byla wczesniej wywolana
        // i przy kolejnym wywolaniu $this->basket() cos bylo nie tak. Problem
        // dotyczy wartosci zmiennej $this->basket
        // @todo
//        if (empty($my_basket)) {
        	$old_dir=getcwd();
			$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
			chdir($path_to_basket);
			require_once("./include/my_ext_basket.inc.php");
			$my_basket=& new My_Ext_Basket();
			$my_basket->_load_from_session();
			chdir($old_dir);
//        }
        $this->basket=&$my_basket;
        return(0);
    } // end basket()
    
    /**
    * Date init
    *
    * \@global object $this->date
    *
    * @access public
    * @return none
    */
    function date() {
        if (empty($this->date)) {
            require_once ("include/date.inc");
            $this->date =& new MyDate;
        }
        return(0);
    } // end date()
    
    /**
    * Currency init
    *
    * \@global object $this->currency
    *
    * @access public
    * @return none
    */
    function currency() {
        global $config;
        
        if (empty($this->currency)) {
            require_once ("include/currency.inc");
            $this->currency =& new Currency2;
        }
        return(0);
    } // end currency()
    
    
    /**
    * Table init
    *
    * \@global object $this->table
    *
    * @access public
    * @return none
    */
    function table() {
        if (empty($this->table)) {
            require_once ("include/table.inc");
            $this->table =& new HTMLTable;
        }
        return(0);
    } // end table()
    
    /**
    * Promotions init
    *
    * \@global object $this->promotions
    *
    * @access public
    * @return none
    */
    function promotions() {
        if (empty($this->promotions)) {
            require_once ("include/promotions.inc");
            $this->promotions =& new Promotions;
        }
        return(0);
    } // end promotions()
    
    /**
    * PayBack init
    *
    * \@global object $this->payback
    *
    * @access public
    * @return none
    */
    function payback() {
        if (empty($this->payback)) {
            require_once ("include/payback/payback_sote.inc.php");
            $this->payback =& new PayBack;
        }
        return(0);
    } // end payback()
    
    
    /**
     * Podmiana katalogu /tmp/ na /tmp2/
     * Tylko na serwerach home.pl - w zwi±zku z ich zabezpieczeniami.
     * Istotne tylko je¿eli uzytkownik ma pobraæ plik przez www
     *
     * @param string $url
     * @return string
     */
    function home_relink($url) {
    	if ($this->home) {
    		return preg_replace("@/tmp/@","/tmp2/",$url);
    	}
    	return $url;
    }
     
    
} // end SOTEeSKLEP

$shop =& new SOTEeSKLEP;
?>