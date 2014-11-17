<?php
/**
 * Funckje zwiazane z obsluga platnosci za posrednictwem eCard (http://www.ecard.pl)
 *
 * @author Marek Jakubowicz 
 * @copyright 2002 (C) SOTE www.sote.pl
* @version    $Id: ecard.inc.php,v 1.2 2004/12/20 18:02:03 maroslaw Exp $
* @package    pay
* @subpackage ecard
 */
 
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

        $o="";
        $o="<form action=$this->urlpost method=post>\n";
        $o.=$this->add_hidden("ORDERNUMBER");
        $o.=$this->add_hidden("AMOUNT");
        $o.=$this->add_hidden("ORDERDESCRIPTION");
        $o.=$this->add_hidden("NAME");
        $o.=$this->add_hidden("SURNAME");
        $o.=$this->add_hidden("SESSIONID");
        $o.=$this->add_hidden("LANGUAGE");
        $o.="<input name=CHARSET type=hidden value ='iso-8859-2'>\n";
        $o.="<input name=JS type=hidden value=0>\n";
        print "<DIV ALIGN=RIGHT>\n";
        $o.=$this->submit;
        print "</DIV>\n";
        print "</FORM>\n";
        $o.="</form>";
        
        return $o;
    } // end form()

} // end eCard class

?>
