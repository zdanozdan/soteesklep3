<?php
/**
 * Elementy forularza okreslajace date
* @version    $Id: date.inc.php,v 2.3 2005/02/11 11:00:14 lechu Exp $
* @package    admin_include
 */
class DateFormElements {
    var $month_days=array("01"=>31,
                          "02"=>28,
                          "03"=>31,
                          "04"=>30,
                          "05"=>31,
                          "06"=>30,
                          "07"=>31,
                          "08"=>31,
                          "09"=>30,
                          "10"=>31,
                          "11"=>30,
                          "12"=>31);

    function months($name) {
        $o="";
        $o.="<select name=\"$name"."[month]\">";
        $month=date("m"); 
        for ($i=1;$i<=12;$i++) {
            if ($i==$month){ $selected=" selected";} else { 
                $selected="";
            }
            $o.="<option value=$i$selected>$i\n";
        }
        $o.="</select>\n";
        return $o;
    }
    
    function days($name) {
        $o="";
        $o.="<select name=\"$name"."[day]\">";
        $month=date("m"); 
        $day=date("d");       
//        $days=$this->month_days[$month];
        $days=31;
        for ($i=1;$i<=$days;$i++) {
            if ($i==$day){ $selected=" selected";} else { 
                $selected="";
            }
            $o.="<option value=$i$selected>$i\n";
        }
        $o.="</select>\n";
        return $o;         
    }

    function years($name) {                 
        $year=date("Y");$start_year=$year-5;
        $o="";
        $o.="<select name=\"$name"."[year]\">";
        for ($i=$start_year;$i<=$start_year+10;$i++) {
            if ($i==$year){ $selected=" selected"; } else {
                $selected="";
            }
            $o.="<option value=$i$selected>$i\n";
        }
        $o.="</select>\n";
        return $o;
    } 

} // end class
?>
