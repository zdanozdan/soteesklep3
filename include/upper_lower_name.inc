<?php
/**
 * Zamien tekst na male litery, pierwsza wielka
* @version    $Id: upper_lower_name.inc,v 2.2 2004/12/20 18:02:58 maroslaw Exp $
* @package    include
 */

function upper_lower_name($name) {
    $name1=strtolower($name);
    $name2=substr($name1,0,1);$name21=strtoupper($name2);
    $name3=substr($name1,1,strlen($name1)-1);    
    $name4=$name21.$name3;
    
    return $name4;
} // end upper_lower_name()

?>
