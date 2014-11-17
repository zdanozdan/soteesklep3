<?php
/**
* Generowanie opcji produktu. Klasa pusta.
*
* @author  krzys@sote.pl 
* @version $Id: empty.inc,v 2.1 2004/12/28 10:44:08 krzys Exp $
* @package xml_options
* @subpackage xml_default
*/

/**
* Obs³uga generowania opcji do produktu - opcje brak
* @package xml_options
* @subpackage xml_defualt
*/
class XML_Default {
    
    /**
    * @var string warto¶c pola xml_options z tabeli main (dla danego produktu)
    */
    var $data;
    
    /**
    * Wy¶wietl opcje produktu. Funkcja wywo³ywana jest w info, jako element formularza dodania do koszyka.
    * 
    * 
    * Je¶li wygenerujemy element formularza o nazwie options[nazwa], to system automatycznie
    * doda warto¶æ tego elelemntu jako opcjê produktu. Mo¿emy w ten sposób generowaæ wiele opcji
    * dla 1 produktu. Np. kolor, rozmiar itp. stworzone z elementów text,select,radio,checkbox itp.
    *
    * @return none
    */
    function show() {
        return;
    } // end show()
    
    /**
    * Oblicz cenê produktu w zale¿no¶ci od wybranych opcji
    *
    * Je¶li dany modu³ nie zmienia ceny, to nake¿y zwróciæ warto¶æ odebrana jako parametr
    *
    * @param  float $price_brutto cena produktu 
    * @return float cena produktu z uwzglêdnieniem atrybutów/opcji
    */
    function price($price_brutto) {
        return $price_brutto;
    } // end price()
    
    /**
    * 
    *    
    * @return boll   true - uproszczona edycja jest dostepna, false w p.w.
    */
    function checkSimpleEdit() {
        return true;
    } // end checkSimpleEdit()
    
} // end XML_Default

/**
* Klasa pomocnicza
* @package xml_options
* @subpackage xml_default
* @ignore
*/
class MyXMLOptions extends XML_Default {};
$my_xml_options =& new MyXMLOptions;

?>

