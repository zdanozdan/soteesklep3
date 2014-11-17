<?php
/**
 * Funckje zwiazane z obsluga platnosci za posrednictwem eCard (http://www.ecard.pl)
 *
 * @author Marek Jakubowicz 
 * @copyright 2002 (C) SOTE www.sote.pl
 */
require_once ("HTTP/Client.php");

class eCard {

    /* Dane przekazywane do eCardu */
    var $ORDERNUMBER;        // numer zamowienia
    var $ORDERDESCRIPTION;   // opis zamowienia
    var $AMOUNT;             // kwota do zaplaty w groszach
    var $NAME;               // imie
    var $SURNAME;            // nazwisko
    var $SESSIONID;          // numer sesji
    var $LANGUAGE="PL";      // PL lub EN jezyk w ktorym ma byc wyswietlona strona
    /* end */ 
        
    /* adres skryptu eCardu */
    var $urlpost="https://localhost:8081";
	
    /* przycisk przej¶cia na strone PolCrad'u */
    var $submit="<input type=submit value='eCard - p³acê kart±'>\n";   

    /**
     * Zamien kwote na format dla PolCard tj. na kwote wyrazona w groszach
     * 
     * @param real $price
     * @return int kwota do zaplaty w groszach
     */
    function price($price) {
        $price=number_format($price,2,".","");
        return intval($price*100);
    } // end

    /**
     * Dodaj element hidden w formularzu
     */
    function add_hidden($name) {
        $value=$this->$name;
        return "<input type=hidden name=$name value='$value'>\n";
    } // end add_hidden()

    /**
     * Generuj opis skrocony zamowienia
     *
     * @param addr object $my_basket
     * @return string opis skrocony zmowienia
     */
    function order_description(&$my_basket) {
        $o="";
        foreach ($my_basket->items as $item) {
            $o.=$item['name']."; ";
        }
        $o=substr($o,0,strlen($o)-2);        

        return $o;
    } // end order_description()
    
    /**
     * Funkcja wyswietla formularz HTML z elementami wymaganymi prez eCard
     */
    function form() {               
        global $lang;
        global $ecard_config;
        
        
        $http =& new HTTP_Client;
        $http->post($ecard_config->ecardServerHash,array(
        													'orderDescription'=>"",
        													'amount'=>$this->price($this->AMOUNT),
        													'currency'=>'985',
        													'merchantId'=>$ecard_config->ecardAccount,
           													'password'=>$ecard_config->ecardPassword,
        													'orderNumber'=>$this->ORDERNUMBER,
        													'verify'=>1
        													)
        			);
        
        			
        			
       $result=$http->_responses[0]['body'];
	    
        
        
        $result=preg_replace("/^\s+/","",$result);
		$result=preg_replace("/\s+$/","",$result);
		if (!$result || $result=="zlyhash") {
	    	print "blad"; 
    		exit(1);
  		} else {
	        $this->ORDERDESCRIPTION=preg_replace("/\"/","\\\"",$this->ORDERDESCRIPTION);
	        $o="<form action=\"".$ecard_config->ecardServerPay."\" method=\"post\">\n";
	        $o.="<input type=\"hidden\" name=\"ORDERNUMBER\" value=\"".$this->ORDERNUMBER."\">\n";
	        $o.="<input type=\"hidden\" name=\"ORDERDESCRIPTION\" value=\"".$this->ORDERDESCRIPTION."\">\n";
	        $o.="<input type=\"hidden\" name=\"AMOUNT\" value=\"".$this->price($this->AMOUNT)."\">\n";
	        $o.="<input type=\"hidden\" name=\"CURRENCY\" value=\"985\">\n";
	        $o.="<input type=\"hidden\" name=\"HASH\" value=\"".$result."\">\n";
	        $o.="<input type=\"hidden\" name=\"MERCHANTID\" value=\"".$ecard_config->ecardAccount."\">\n";
	        $o.="<input type=\"hidden\" name=\"SESSIONID\" value=\"".$this->SESSIONID."\">\n";
	        $o.="<input type=\"hidden\" name=\"NAME\" value=\"".$this->NAME."\">\n";
	        $o.="<input type=\"hidden\" name=\"SURNAME\" value=\"".$this->SURNAME."\">\n";
	        $o.="<input type=\"hidden\" name=\"LANGUAGE\" value=\"".$ecard_config->ecardLang."\">\n";
	        $o.="<input type=\"hidden\" name=\"AUTODEPOSIT\" value=\"0\">\n";
	        $o.="<input type=\"hidden\" name=\"CHARSET\" value=\"iso-8859-2\">\n";
		$o.="<input TYPE=\"hidden\" name=\"PAYMENTTYPE\" value=\"".$ecard_config->ecardPayType."\">\n";
	        $o.="<input type=\"hidden\" name=\"LINKOK\" value=\"http://".$_SERVER['HTTP_HOST']."/".$ecard_config->ecardReturnUrl."?\">\n";
	        $o.="<input type=\"hidden\" name=\"LINKFAIL\" value=\"http://".$_SERVER['HTTP_HOST']."/".$ecard_config->ecardCancelReturnUrl."?\">\n";
	        print "<DIV ALIGN=RIGHT>\n";
	        $o.="<input type=\"submit\" name=\"JS\" value=\"Dalej\">\n";
	        print "</DIV>\n";
	        print "</FORM>\n";
	        $o.="</form>";
	
	        return $o;
  		}    
    } // end form()

} // end eCard class

?>
