<?php
/**
* Obsluga daty, funckje zwiazane z datami
*
* @author  m@sote.pl
* @version $Id: date.inc,v 2.4 2004/12/20 18:02:51 maroslaw Exp $
* @package    include
*/

require_once ("Date/Calc.php");

class MyDate extends Date_Calc {
    
    /**
    * Zmien format daty z timestamp na YYYY-MM-DD
    *
    * @param string $date      data w formacie timestamp
    * @param string $separator separator
    *
    * @access public
    * @return string data
    */
    function timestamp2YYYYMMDD($date,$separator="-") {
        if (ereg("^[0-9]+$",$date)) {
            $new_date=(substr($date,0,4)).$separator.(substr($date,4,2)).$separator.(substr($date,6,2));
        } else $new_date='';
        return $new_date;
    } // end timestamp2YYYYMMDD()
    
    // alias->timestamp2YYYYMMDD()
    function timestamp2yyyy_mm_dd($date,$separator="-") {
        return $this->timestamp2YYYYMMDD($date,$separator);
    } // end timestamp2yyyy_mm_dd()
    
    
    /**
    * Zmien format daty z timestamp na YYYY-MM-DD HH:mm
    *
    * @param string $date      data w formacie timestamp
    * @param string $separator separator
    *
    * @access public
    * @return string data
    */
    function timestamp2YYYYMMDDTime($date,$separator="-") {
        if (ereg("^[0-9]+$",$date)) {
            $new_date=(substr($date,0,4)).$separator.(substr($date,4,2)).$separator.(substr($date,6,2)).
            " ".(substr($date,8,2)).":".(substr($date,10,2));
        } else $new_date='';
        return $new_date;
    } // end timestamp2YYYYMMDDTime()
    
    // alias->timestamp2YYYYMMDDTime()
    function timestamp2yyyy_mm_dd_time($date,$separator="-") {
        return $this->timestamp2YYYYMMDDTime($date,$separator);
    } // end timestamp2yyyy_mm_dd()
    
} // end class MyDate

?>
