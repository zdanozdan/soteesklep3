<?php
/**
* Generowanie opcji produktu.
*
* @author  m@sote.pl 
* @version $Id: xml_default.inc,v 2.9 2005/04/01 12:18:55 maroslaw Exp $
* @package xml_options
* @subpackage xml_default
*/

/**
* Obs³uga generowania opcji do produktu
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
    * Je¶li wygenerujemy element formularza o nazwie options[nazwa], to system automatycznie
    * doda warto¶æ tego elelemntu jako opcjê produktu. Mo¿emy w ten sposób generowaæ wiele opcji
    * dla 1 produktu. Np. kolor, rozmiar itp. stworzone z elementów text,select,radio,checkbox itp.
    *
    * @return none
    */
    function show() {
        global $lang,$rec;
        
        if (! empty($this->data)) {
            print "<form action=/go/_basket/index.php method=POST>\n";
            print "<input type=hidden name=id value='".$rec->data['id']."'>\n";
            print @$lang->info_options."<select name=options>\n";
            $tab=split(';',$this->data,100);
            foreach ($tab as $attr) {
                if (! empty($attr)) {
                    print "<option value='$attr'>$attr\n";
                }
            }
            print "</select>\n";
            print "<input type=submit value='".$lang->info_attrib_order."'>\n";
            print "</form>\n";
        }
        
        return;
    } // end show()
    
    /**
    * Oblicz cenê produktu w zale¿no¶ci od wybranych opcji
    *
    * Je¶li dany modu³ nie zmienia ceny, to nale¿y zwróciæ warto¶æ odebrana jako parametr
    *
    * @param  float $price_brutto cena produktu 
    * @return float cena produktu z uwzglêdnieniem atrybutów/opcji
    */
    function price($price_brutto) {
        return $price_brutto;
    } // end price()
    
    /**
    * Sprawdz czy dany typ danych mozna edytowac w formie uproszczonej (wprowadzajac dane do polaa <input ...>
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

