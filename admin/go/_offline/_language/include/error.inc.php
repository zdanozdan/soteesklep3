<?php
/**
 * Obsluga b³edów systemu offline
 *
 * @author  rdiak@sote.pl
 * @version $Id: error.inc.php,v 1.1 2005/04/21 07:12:07 scalak Exp $
* @package    offline
* @subpackage main
 */

/**
 * Klasa OfflineError
 *
 * @package offline
 * @subpackage admin
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
    } // end OfflineError

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
    function write($error,$num_record='',$name='') {
        global $lang;
        
        $data = date("Y.m.d H:i:s");
        $str=$data."\t".$num_record."\t".$lang->offline_field." <b> ".$name."</b>: \"".$error."\"\n";
        fputs($this->fd,$str);
        return true;
    } // end write 
    
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
        if(empty($num_record)) {
        	$num_record="&nbsp;";
        }
        $str=$data."\t".$num_record."\t<b>".$error."</b>\n";
        fputs($this->fd,$str);
        return true;
    } // end write_other
} // end class OfflineError
?>
