<?php
/**
 * Linki nad lista produktow.
* @version    $Id: record_row_links.inc,v 2.3 2004/12/20 18:02:56 maroslaw Exp $
* @package    include
 */
class RecordRowLinks {
    var $long;            // link do pelnej prezentacji ze zdjeciem
    var $short;           // link do skroconej prezentacji
    var $session_param="session_id"; // zmienna sesji

    /**
     * Generuj liki do pelnej i skroconej prezentacji rekordu
     * Odczytaj przekazane parametry i dodaj parametr oznaczajacy zmiane rodzaju wyswietlania; 
     * zapobiegnij dublowaniu sie wywolywanych parametrow
     */
    function set_links() {
        global $_REQUEST;
        global $_SERVER;

        // generuj prefix - sciezka+nazwa skryptu
        $this->prefix=$_SERVER['SCRIPT_NAME'];

        $my_REQUEST=$_REQUEST;
        // ustaw wywolanie na 1 strone (wymagane przy zmianie rodzaju wyswietlania rekordow, ze wzgledu na mozliwa zmaine
        // ilosci wyswietlanych rekordow. Wtedy zmienia sie podzial stron i trzeba wyswietlic wszystko od 1 strony).
        if (! empty($my_REQUEST['page'])) {
            $my_REQUEST['page']=1;
        }
        $my_REQUEST['record_row']="short";
        $this->short=$this->prefix.$this->gen_url($my_REQUEST);

        $my_REQUEST['record_row']="long";
        $this->long=$this->prefix.$this->gen_url($my_REQUEST);                       

        return;
    } // end set_links()

    /**
     * Generuj adres URL (GET) na podstawie tablicy zmiennych
     */
    function gen_url(&$my_REQUEST) {
        $url="";
        /*
        print "<pre>";
        print_r($my_REQUEST);
        print "</pre>";
        */
        
        reset($my_REQUEST);$first=true;        
        while (list($key,$val) = each($my_REQUEST)) {
            if ($first==true) {
                if ($key!=$this->session_param && !is_array($val)) {
                    $url="?$key=".urlencode($val);
                } else $url="?null=1";
                $first=false;
            } else {
                if ($key!=$this->session_param && !is_array($val)) {
                    $url.="&$key=".urlencode($val);
                }
            }
        }
        return $url;
        
    } // end gen_url()
    
} // end class RecordRowLinks

$rrlinks = new RecordRowLinks;
$rrlinks->set_links();

?>
