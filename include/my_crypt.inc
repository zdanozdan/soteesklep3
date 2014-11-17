<?php
/**
 * Generuj klucze kodowania; koduj i dekoduj dane wg. ustalonego algorytmu.
 * 
 * @author m@sote.pl
 * @version $Id: my_crypt.inc,v 2.4 2004/12/20 18:02:54 maroslaw Exp $
* @package    include
 */
class MyCrypt {
    var $prv_key;
    var $pub_key;
        
    /**
     * Konstruktor klasy
     */
    function MyCrypt() {
        global $config;
        $this->pub_key=md5($config->salt);
        return(0);
    } // end MyCrypt()

    function gen_keys($password="") {
        global $config;        
        $this->prv_key=md5($password.$config->salt);
        $this->pub_key=md5($config->salt);
        return(0);
    } // end gen_keys()

    /**
     * Koduj dekoduj dane
     *
     * @param string klucz kodowania 
     * @param strong dane
     * @param string $options de - dekodowanie, "" - kodowanie
     * @return kryptogram|tekst jawny
     */
    function endecrypt($key="",$data="",$options="") {
        if (empty($key)) {
            $this->gen_keys();
            $key=$this->pub_key;
        }
        require_once("lib/RC4Crypt/class.rc4crypt.php");
        $rc4 = new rc4crypt;
        return $rc4->endecrypt($key,$data,$options);
    } // end endecrypt()

} // end class MyCrypt

$my_crypt = new MyCrypt;
?>
