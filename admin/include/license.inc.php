<?php
/**
 * Klasa obslugujaca dane zapisane w numerze licencji
 *
 * @author  m@sote.pl
 * @version $Id: license.inc.php,v 2.5 2006/01/10 12:39:00 maroslaw Exp $
* @package    admin_include
 */

 /* Klasa obs³ugi daty */
require_once ("Date/Calc.php");

/* @package license */
class License {
    
    /**
    * @var string klucz licencji ver. 2.5
    */        
    var $license_key="0964782637846146EP34124123418925";  
    // var $license_key="78513784515612345841926359KGFTYI";  // klucz licencji ver. 3.0 
    
    /**
     * Sprawdz numer licencji
     * 
     * @param string $license numer licencji
     *
     * @return bool true numer licencyjny poprawny
     */
    function check($license) {
        $license=ereg_replace(" ","",$license);
        $license=ereg_replace("-","",$license);
        $l=strlen($license);
        if ($l!=24) return false;

        $license_nosign=substr($license,0,$l-8);
        $license_sign=substr($license,$l-8,8);

        $code=md5($this->license_key.$license_nosign);
        $code_sign=substr($code,strlen($code)-8,8);

        if ($code_sign==$license_sign) return true;        
        return false;
    } // end check()
    
    /**
     * Odczytaj date zapisana licencji
     *
     * @return string data utworzenia waznosci licencji
     */
    function get_date() {
        global $config;
        
        $license=$config->license['nr'];
        $this->license=$license;

        $this->yyyy=substr($license,0,4);
        $this->mm=substr($license,5,2);
        $this->dd=substr($license,7,2);        
        $this->date="$this->yyyy-$this->mm-$this->dd";

        return $this->date;
    } // end get_date()

    /**
     * Odczytaj liczbe dni waznosci licencji
     *
     * @return string liczba dni waznosci licencji
     */
    function get_days() {        
        $this->days=substr($this->license,10,2);
        return $this->days;
    } // end get_days()

    /**
     * Sprawdz date waznosci licencji
     *
     * @public
     */
    function check_date() {        
        $this->get_date();
        $this->get_days();      

        $date_calc = new Date_Calc;

        $start_dd=$this->dd;
        $active_days=0;
        for ($i=$start_dd;$i<$this->days+$start_dd;$i++) {
            if ($active_days>0) $active_days++;

            $dd=$date_calc->NextDay($i,$this->mm,$this->yyyy);

            $yyyy2=substr($dd,0,4);
            $mm2=substr($dd,4,2);
            $dd2=substr($dd,6,2);
            if (($yyyy2=date("Y")) && ($mm2==date("m")) && ($dd2==date("d"))) {
                $active_days=1;
            } // end if          
        } // end for
        
        $this->yyyy=substr(@$dd,0,4);
        $this->mm=substr(@$dd,4,2);
        $this->dd=substr(@$dd,6,2);

        // ilosc dni aktywnosci licencji
        $this->active_days=$active_days;

        // data aktywnosci licencji
        $this->active_date="$this->yyyy-$this->mm-$this->dd";
        if ($this->days==0) return true;        // nie ma limitu czasowego
        if ($date_calc->isPastDate($this->dd,$this->mm,$this->yyyy)) return false;        

        return true;
    } // end check_date()

    /**
    * Sprawd¼ czy kod weryfikacyjny podany do danej  licencji i stringu jest prawidlowy
    *
    * @param string $code
    * @return bool
    */
    function checkCode($code) {    
        global $config;
        $code1=md5($config->license['nr'].$this->license_key.$code);                
        return substr($code1,26,6);    
    } // end checkCode()
    
} // end class License

?>
