<?php
/**
 * Klasa zawira dodatkowe funkcje do offlina
 *
 * @author  rdiak@sote.pl
 * @version $Id: encode.inc.php,v 1.1 2005/04/21 07:12:07 scalak Exp $
* @package    offline
* @subpackage main
 */


/**
 * Klasa OfflineEncode
 *
 * @package offline
 * @subpackage admin
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
    } // end OfflineEncode

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
    } // end encoding_win1250_to_8859

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
    }// end encoding_8859_to_win1250
    
    function encoding_mazowia_to_8859($string) {
        $string = strtr($string,
                         "\x8f\x95\x90\x9c\xa5\xa3\x98\xa0\xa1\x86\x8d\x91\x92\xa4\xa2\x9e\xa6\xa7",                      
	        "\xa1\xc6\xca\xa3\xd1\xd3\xa6\xac\xaf\xb1\xe6\xea\xb3\xf1\xf3\xb6\xbc\xbf"
                        );
      return $string;
    } // end encoding_win1250_to_8859
       
        
} // end class OfflineEncode 
?>
