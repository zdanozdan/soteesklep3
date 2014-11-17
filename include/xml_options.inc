<?php
/**
* Przedstawianie elementow zawartych w polu xml_options
*
* \@global string $rec->data['xml_options']
* @version    $Id: xml_options.inc,v 2.11 2004/12/28 10:43:59 krzys Exp $
* @package    include
*/

/**
* @package xml_options
*/
class XMLOptions {
    /**
    * Sprawdz typ danych zawartych w xml_options
    *
    * @param $value wartosc pola xml_options
    * @return class nazwa klasy zawierajacej funkcje obslugujace wartosci pola xml_options
    *
    * \@global string $__xml_options_type rodzaj opcji
    */
    function check_type($value) {
        global $config;
        global $__xml_options_type;

        if (@$config->catalog_mode==1) {
            $__xml_options_type="empty";
            return "empty";
        }
        if (eregi("<type>mp3</type>",$value)) {
            $__xml_options_type="mp3";
            return "mp3";
        }
        if (eregi("<type>groups</type>",$value)) {
            $__xml_options_type="groups";
            return "groups";
        }
        if (eregi("^multi",$value)) {
            $__xml_options_type="multi";
            return "multi_group";
        }
        if (eregi("^music",$value)) {
            $__xml_options_type="music";
            return "multi_group";
        }

        return "xml_default";

    } // end check_type()
} // end class XMLOptions

if (! empty($rec->data['xml_options'])) {
    $classname = XMLOptions::check_type($rec->data['xml_options']);

    if (! empty($classname)) {
        include_once ("include/xml_options/$classname.inc");
        // przekaz parametr pobrany z bazy z pola xml_options
        $my_xml_options->data=&$rec->data['xml_options'];
    }
}

?>
