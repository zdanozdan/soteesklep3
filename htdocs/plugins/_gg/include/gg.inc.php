<?php
/**
* Aktualizacja statusu numerów GG
*
* Modu³ uruchamiany jako proces z CRONa aktualizuje periodycznie status numerów GG zawartych
* w pliku konfiguracyjnym wej¶ciowym. Wykonanie odpowiednich metod klasy spowoduje wygenerowanie
* pliku config_gg.inc.php po stronie tematów z okre¶lonymi statusami numerów GG
*
* @author  lech@sote.pl
* @version $Id: gg.inc.php,v 1.3 2005/06/07 12:40:07 maroslaw Exp $
* @package gg
*/

/**
* Edycja wersji jêzykowych
*
* Klasa implementuje metody umo¿liwiaj±ce aktualizacjê statusów numerów GG
* @package gg
*/

class GG {

    /**
    * Tablica, której klucze to numery gg, a warto¶ci to statusy: 1 - niedostêpny, 2 - dostêpny, 3 - zaraz wracam
    */
    var $gg_array;

    /**
    * Adres URL serwera statusów GG
    */
    var $url = "http://status.gadu-gadu.pl/users/status.asp";

    /**
    * Odczytanie numerów gg z pliku (format: ka¿da linia to kolejny numer gg) do $gg_array
    *
    * @param string $file ¦cie¿ka do pliku konfiguracyjnego wej¶ciowego
    * @return none
    */
    function readNumbers($file_path = "/plugins/_gg/config/numbers.txt") {
        global $DOCUMENT_ROOT, $shop;
        if ($shop->home != 1) {
            $file_path = $DOCUMENT_ROOT . "" . $file_path;
        } else {
            $file_path = preg_replace("/^htdocs/", "", $file_path);
        }
        if(is_file($file_path)) {
            $fp = fopen($file_path, 'r');
            $contents = fread($fp, filesize($file_path));
            fclose($fp);
            $tmp = explode("\n", $contents);
            for($i = 0; $i < count($tmp); $i++) {
                if(!empty($tmp[$i])) {
                    $this->gg_array[$tmp[$i]] = 0;
                }
            }                        
            
            return true;
        }
        else {
            die ("Error: Unknown file '$file_path'");
        }
    }

    /**
    * Odczytanie statusów numerów GG i zapisanie ich w tablicy gg_array
    *
    * @return none
    */
    function readStatuses() {
        reset($this->gg_array);
        $tmp = array();
        while (list($key, $val) = each($this->gg_array)) {
            $req =& new HTTP_Request($this->url . "?id=" . $key. "&styl=2");
            $req->setMethod(HTTP_REQUEST_METHOD_GET);
            $res = $req->sendRequest();
            if (PEAR::isError($res)) {
                die($res->getMessage());
            }
            $tmp[$key] = $req->getResponseBody();
        }
        $this->gg_array = $tmp;
    }

    /**
    * Zapisanie numerów gg do pliku (format: tablica $config_gg->gg, klucze to numery, warto¶ci to statusy 1, 2 i 3)
    *
    * @param string $file ¦cie¿ka do pliku konfiguracyjnego wyj¶ciowego
    * @return none
    * @deprecated 
    */
    function updateStatusesFTP($path = "/plugins/_gg/config") {
        global $gen_config, $ftp;
        $ftp->connect();
        $gen_config->auto_ftp = false;
        $gen_config->config_dir = $path;
        $gen_config->config_file="config_gg.inc.php";    // nazwa generowanego pliku
        $gen_config->classname="ConfigGG";               // nazwa klasy generowanego pliku
        $gen_config->class_object="config_gg";           // 1) nazwa tworzonego obiektu klasy w/w
        $gen_config->vars=array("gg");                   // jakie zmienne beda generowane
        $gen_config->config=array();                     // przekaz aktualne wartosci obiektu 1)

        // generuj plik konfiguracyjny
        $comm=$gen_config->gen(array("gg"=>$this->gg_array));
        $ftp->close();
    }

    /**
    * Zapisanie numerów gg do pliku w formacie zserializowanym wg $this->gg_array
    *
    * @author m@sote.pl
    * @param  string $file ¦cie¿ka do pliku konfiguracyjnego wyj¶ciowego
    * @return none
    */
    function updateStatuses($path = "/plugins/_gg/config") {
        global $DOCUMENT_ROOT;
        $file_gg=$DOCUMENT_ROOT.$path."/gg_status.txt";        
        if ($fd=fopen($file_gg,"w+")) {
            $data=serialize($this->gg_array);
            fwrite($fd,$data,strlen($data));
            fclose($fd);
        } else return false;
        return true;
    } // end updateStatuses()

    /**
    * Wykonanie ca³ego procesu pobrania numerów, sprawdzenia stanu i aktualizacja pliku wyj¶ciowego
    * 
    * @return none
    */
    function update() {
        $this->readNumbers();
        $this->readStatuses();
        $this->updateStatuses();
    } // end update()
    
} // end class

?>