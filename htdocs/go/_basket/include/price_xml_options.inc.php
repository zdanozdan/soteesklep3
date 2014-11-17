<?php
/**
* Sprawd¼ czy wybrana opcja zmienia cenê produktu.
*
* @author m@sote.pl
* @version $Id: price_xml_options.inc.php,v 2.6 2006/02/09 10:34:00 maroslaw Exp $
* @package    basket
*/

if (@$global_secure_test!=true) die ("Niedozwolone wywolanie");

/**
* Obliczanie ceny produktu na podstawie opcji.
* 
* @package basket
*/
class Price_XML_Options {

    // {{{ get_price()

    /**
    * Sprawdz wybrana opcje przy produkcie. Sprawdz czy wybranie opcji zmienia cene produktu.
    * Jesli, tak to odczytaj ta cene.
    * Jako dane wejsciowe mamy parametr przekazany przez GET oraz dane rekodu z bazy
    *
    * @param float $price_brutto cena domyslna produktu - wartosc pola price_brutto
    * @param string $xml_options opcje odczytane z bazy dla danego rekordu
    * @return float cena zakupu produktu
    */
    function get_price($price_brutto,$xml_options) {

        // zapamiêtaj cenê bez modyfikowania warto¶ci przez "atrybuty"
        $price_copy=$price_brutto;

        $rec->data['xml_options']=$xml_options;
        require_once ("include/xml_options.inc");
        $this->my_xml_options =& new MyXMLOptions;
        if (! empty($this->result)) {
            $this->my_xml_options->result=&$this->result;
        }
        $price_brutto=$this->my_xml_options->price($price_brutto,$xml_options);

        // Sprawd¼ jaka waluta jest przypisana do produktu, je¶li id_currency jest > 1, to przelicz kurs na walutê
        // domy¶ln±.
        $args=func_get_args();
        if (sizeof($args)>2)  {
            $args=array_slice($args,2);
            if ($args[0]>1) {
                $id_currency=$args[0];
                /*
                $price_currency=$args[1];
                global $config;
                $price_brutto=$price_copy+(($price_brutto-$price_copy)*$config->currency_data[$id_currency]);
                */
                global $shop;
                $shop->currency();
                $price_brutto=$price_copy+$shop->currency->price($price_brutto-$price_copy,$id_currency,CURRENCY_REVERSE);
            }
        }

        return $price_brutto;
    } // end get_price()

    // }}}

} // end class Price_XML_Options

?>