<?php
/**
 * 
 *
 * @author  rdiak@sote.pl
 * @version $Id: encode.inc.php,v 1.2 2004/12/20 17:59:25 maroslaw Exp $
* @package    admin_include
 */

class OfflineEncode {

    var $source_encoding='';
    var $target_encoding='';
    
    /**
     * Konstruktor obiektu OfflineEncode inicjuje zmienne 
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    function OfflineEncode() {
        global $config;
        $this->source_encoding=$config->offline_source_encoding;
        $this->target_encoding=$config->offline_target_encoding;
        return true;
    }

    /**
     * Funkcja konwertujaca string z standardu win1250 na iso-8859-2 
     *
     * @param  string $string  ciag znakow, 
     *
     * @return string $string  ciag znakow po konwersji
     *
     * @author rdiak@sote.pl
     */

    function encoding_win1250_to_8859($string) {
        $string = strtr($string,
                        "\xA5\x8C\x8F\xB9\x9C\x9F",
                        "\xA1\xA6\xAC\xB1\xB6\xBC"
                        );
      return $string;
    } // end func encoding_win1250_to_8859

    /**
     * Funkcja konwertujaca string z standardu iso-8859-2 na win1250
     *
     * @param  string $string  ciag znakow, 
     *
     * @return string $string  ciag znakow po konwersji
     *
     * @author rdiak@sote.pl
     */

    function encoding_8859_to_win1250($string) {
        $string = strtr($string, 
                        "\xA1\xA6\xAC\xB1\xB6\xBC",
                        "\xA5\x8C\x8F\xB9\x9C\x9F"
                        );
        return $string;
    } // end func  encoding_8859_to_win1250
      
} // end class OfflineEncode 

?>
