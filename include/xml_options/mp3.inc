<?php
/**
* Obsluga MP3
* @version    $Id: mp3.inc,v 2.3 2004/12/20 18:03:02 maroslaw Exp $
* @package    include
*/
class MP3 {
    var $data;           // zawartosc pola xml_options z bazy
    var $max_files=100;  // maksymalna liczba plikow mp3
    var $dir;            // kataog z plikami mp3
    
    function show() {
        $xml=ereg_replace('&','&#38;',$this->data);
        
        $parser = xml_parser_create();
        xml_parse_into_struct($parser,$xml,$values,$tags);
        xml_parser_free($parser);
        
        foreach ($values as $index) {
            $tag=$index['tag'];
            $type=$index['type'];
            $level=$index['level'];
            if (! empty($index['value'])) {
                $value=$index['value'];
            } else $value='';
            
            // katalog z plikami mp3
            if (($tag=="DIR") && ($level==2)){
                $this->dir=$value;
            }
            
            // nazwa programu do odsluchiwania plikow
            if (($tag=="PLAYER") && ($level==2)){
                $this->player=$value;
            }
            
            
            // wskazanie na adres do pobrania programu do odsluciwania plikow
            if (($tag=="FTP_PLAYER") && ($level==2)){
                $this->ftp_player=$value;
                // naglowek wyswietlanie plikow mp3
                $this->head();
            }
            
            if (($level==3) && ($tag=="MP3FILE")) {
                $data=array();
                $data['file']=$value;
            }
            if (($level==3) && ($tag=="MP3NAME")) {
                $data['name']=$value;
                // prezentuj pojedynczy utwor muzyczny MP3
                $this->mp3file($data);
            }
            
        } // end foreach
        
        return;
    } // end show()
    
    /**
    * Prezentuj pojedynczy utwor muzyczny MP3
    *
    * @param array $data klucze file,name - nazwa pliku i tytul utowru
    */
    function mp3file (&$data) {
        $file=&$data['file'];
        $name=&$data['name'];
        print "<li> <a href=/music/$this->dir/$file><u>$name</u></a>\n";
        return;
    } // end mp3file
    
    /**
    * Naglowek
    */
    function head() {
        global $lang;
        
        
        print $lang->mp3['title']."<BR>";
        print "(".$lang->mp3['ftp']." ";
        print "<a href=$this->ftp_player>$this->player</a>)";
    } // end head()
    
    function price($price_brutto) {
        return $price_brutto;
    }
    
    /**
    * Sprawdz czy dany typ danych mozna edytowac w formie uproszczonej (wprowadzajac dane do polaa <input ...>
    *
    * @access public
    * @return boll   true - uproszczona edycja jest dostepna, false w p.w.
    */
    function checkSimpleEdit() {
        return false;
    } // end checkSimpleEdit()
    
} // end MP3

class MyXMLOptions extends MP3 {};
$my_xml_options = new MyXMLOptions;

?>
