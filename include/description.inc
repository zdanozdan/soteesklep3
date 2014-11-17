<?php
/**
 * Generowanie opisow na podstawie danych z bazy, generowanie skroconego opisu
 *
 * @author  m@sote.pl
 * @version $Id: description.inc,v 2.4 2004/12/20 18:02:51 maroslaw Exp $
* @package    include
 */

require_once ("lib/SDConvertText/class.SDConvertText.php");

class Description {
    var $allowed_tags=array('<br>','<a>');
    var $maxchars=256;              // maksymalna liczba znakow w opisie skroconym

    /**
     * Wyswietl skrocony opis produktu. Jesli jest opis skrocony $short, to
     * wyswietl go bez zmian, jesli nie ma to generuj skrot opisu na podstawie $text
     *
     * @param string $short skrocony opis
     * @param string $text  pelen opis, wg. ktorego opcjonalnie jest generowany skrot
     * @return string skrocony opis
     */
    function short($short,$text) {
        if (! empty($short)) return $short;
        if (strlen($text)<$this->maxchars) return $text;                               
        return $this->convertHTML2TXT($text);
    } // end short()

    
    /**
    * Konwertuj html->txt
    *
    * @param string $text kod w HTML lub TXT
    * @return string tekst w formacie TXT
    */
    function convertHTML2TXT($text) {
        global $ct;
        
        if (empty($ct)) $ct =& new SDConvertText;        
                
        $desc=$ct->dropHTML($text,$this->allowed_tags);
        $desc=substr($desc,0,$this->maxchars);
        $tdesc=array();
        $tdesc=split(" ",$desc);$ltdesc=sizeof($tdesc);
        
        $i=0;$o="";
        while ($i<$ltdesc-2) {
            $word=$tdesc[$i]." ";             
            $o.=$word;
            $i++;
        }
        
        if (! empty($text)) {
            $o.="...";
        }
        
        return $o;
    } // end convertHTML2TXT()
    
} // end class Description

$description = new Description;

?>
