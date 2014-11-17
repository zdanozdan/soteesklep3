<?php
/**
 * Odczytywanie danych z formatu CSV i przwtworzenie go na format tablicy PHP
 *
 * @author  rdiak@sote.pl
 * @version $Id: error.inc.php,v 1.2 2004/12/20 17:58:34 maroslaw Exp $
* @package    offline
* @subpackage main_keys
 */

class OfflineError {

    var $fd='';                   // uchwyt do pliku
    var $filename='';             // nazwa pliku z logami 
    var $path='';                 // sciezka do pliku z logami 
    
    /**
     * Konstruktor obiektu OfflineError inicjuje zmienne 
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    function OfflineError() {
        global $config;
        global $DOCUMENT_ROOT;

        $this->filename=$config->offline_file_error;
        $this->path=$config->offline_path_file;
        $file=$DOCUMENT_ROOT."/".$this->path."/".$this->filename;
        if($fd=fopen($file,"w+")) {
            $this->fd=$fd;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Funkcja zapisuje blad weryfikacji pola do error.log 
     *
     * @param  string $error kod  bledu, 
     * @param  int    $num_record numer rekordu, 
     * @param  string $name nazwa pola w ktorym wystapil blad, 
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    /*function write($error,$num_record='',$name='') {
        global $lang;
	
	$data = date("Y.m.d H:i:s");
        $str=$data."\t".$num_record."\t$lang->offline_error_record_numberW rekodzie numer ".$num_record." $lang->offline_fieldpole<b> ".$name."</b> wykazuje blad <b> \"".$error."\"</b>\n";
        fputs($this->fd,$str);
        return true;
    }*/
    
    /**
     * Funkcja zapisuje blad weryfikacji pola do error.log 
     *
     * @param  string $error kod  bledu, 
     * @param  int    $num_record numer rekordu, 
     * @param  string $name nazwa pola w ktorym wystapil blad, 
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     * \@modified_by piotrek@sote.pl
     */
    
    function write($error,$num_record='',$name='') {
        global $lang;
        
        $data = date("Y.m.d H:i:s");
        $str=$data."\t".$num_record."\t".$lang->offline_field." <b> ".$name."</b>: \"".$error."\"\n";
        fputs($this->fd,$str);
        return true;
    }
    
    /**
     * Funkcja zapisuje inne blady do error.log 
     *
     * @param  string $error kod  bledu, 
     * @param  int    $num_record numer rekordu, 
     * @param  string $name nazwa pola w ktorym wystapil blad, 
     *
     * @return boolean true/false
     *
     * @author rdiak@sote.pl
     */

    function write_other($error,$num_record='',$name='') {
        $data = date("Y.m.d H:i:s");
        $str=$data."\t".$num_record."\t<b>".$error."</b>\n";
        fputs($this->fd,$str);
        return true;
    }




} // end class myError

?>
