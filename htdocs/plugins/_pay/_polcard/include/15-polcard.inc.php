<?php
/**
* Funckje zwiazane z obsluga IOO ePay PolCard'u
*
* @author Marek Jakubowicz
* @copyright 2002 (C) SOTE www.sote.pl
* @version    $Id: polcard.inc.php,v 1.6 2006/02/15 09:49:01 lukasz Exp $
* @package    pay
* @subpackage polcard
*/

/**
* Klasa obs³uguj±ca uproszczony system p³atno¶ci PolCard. Generowanie formularza, parametrów itp.
* @package polcard
* @subpackage htdocs_simple
*/
class PolCard {
    
    /**
    * @var string numer zamówienia identyfikuj±cy transakcjê
    */
    var $order_id;
    
    /**
    * @var int kod punktu przydzielony przez PolCard
    */
    var $pos_id;
    
    /**
    * @var int kwota transakcji wyra¿ona w groszach
    */
    var $amount;
    
    /**
    * @var string PL lub EN jêzyk w którym ma byæ wy¶wietlona strona
    */
    var $language="PL";
    
    /**
    * @var string adres email zamawiaj±cego
    */
    var $email;
    
    /**
    * @var string flaga identyfikuj±ca transakcje testowe (Y/N)
    */
    var $test="N";
    
    /**
    * @var string adres IP zamawiaj±cego (xxx.xxx.xxx.xxx)
    */
    var $client_ip;
    
    /**
    * @var string pierwsza linia adresu wysy³ki
    */
    var $street;
    
    /**
    * @var string numer zwi±zany z adresem (prawie zawsze numer domu)
    */
    var $street_n1;
    
    /**
    * @var string numer zwi±zany z adresem (prawie zawsze numer mieszkania)
    */
    var $street_n2;
    
    /**
    * @var string numer telefonu podany w sklepie
    */
    var $phone;
    
    /**
    * @var string nazwa miasta adresu wysy³ki
    */
    var $city;
    
    /**
    * @var string kod pocztowy z adresu wysylki
    */
    var $postcode;
    
    /**
    * @var string kod kraju z adresu wysy³ki
    */
    var $country="POL";
    
    /**
    * @var string numer sesji  tylko dla polcard_adv
    */
    var $session_id='';
    
    /**
    * @var int minimalna kwota transakcji w groszach
    */
    var $min_amount="1";
    
    /**
    * @var int maksymalna kwota transakcji w groszach
    */
    var $max_amount="4000";
    
    /* adres skryptu PolCradu */
    var $urlpost="https://post.polcard.com.pl/cgi-bin/autoryzacja.cgi";
    
    /* przycisk przej?cia na strone PolCrad'u */
    var $submit="<input type=submit value='PolCard - p³acê kart±'>\n";
    
    /**
    * Konstruktor
    *
    * \@global string $this->session_id numer sesji
    */
    function polcard() {
        global $sess;
        $this->session_id=$sess->id;
        return(0);
    } // end polcard
    
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
    *
    * @param string  $name nazwa pola formularza
    * @return string kod HTML
    */
    function add_hidden($name) {
        $value=$this->$name;
        return "<input type=hidden name=$name value='$value'>\n";
    } // end add_hidden()
    
    /**
    * Funkcja wyswietla formularz HTML z elementami wymaganymi prez IOO-ePay
    */
    function form() {
        global $config;
        global $lang;
        
        // sprawdz czy nie przekroczono maksymalnej kwoty transakcji karta
        if ($this->amount>($this->max_amount*100)) {
            $o=" <font color=red>$lang->polcard_amount_max_error
    		 $this->max_amount $config->currency</font>";
            return $o;
        }
        
        // sprawdz czy nie przekroczono minimalnej kwoty transakcji karta
        if ($this->amount<($this->min_amount*100)) {
            $o=" <font color=red>$lang->polcard_amount_min_error
		     $this->min_amount PLN</font>";
            return $o;
        }
        
        $o="";
        $o="<form action=$this->urlpost method=post>\n";
        $o.=$this->add_hidden("order_id");
        $o.=$this->add_hidden("pos_id");
        $o.=$this->add_hidden("amount");
        $o.=$this->add_hidden("language");
        $o.=$this->add_hidden("email");
        $o.=$this->add_hidden("test");
        $o.=$this->add_hidden("client_ip");
        $o.=$this->add_hidden("street");
        $o.=$this->add_hidden("street_n1");
        $o.=$this->add_hidden("street_n2");
        $o.=$this->add_hidden("phone");
        $o.=$this->add_hidden("city");
        $o.=$this->add_hidden("postcode");
        $o.=$this->add_hidden("country");
        if (in_array("polcard_adv",$config->plugins)) {
            $o.=$this->add_hidden("session_id");
        }
        $o.=$this->submit;
        $o.="</form>";
        
        return $o;
    } // end form()
    
} // end PolCard class

?>
