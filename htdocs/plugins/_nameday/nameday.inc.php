<?php
/**
* @version    $Id: nameday.inc.php,v 1.2 2004/12/20 18:01:59 maroslaw Exp $
* @package    nameday
*/
/*
* Kalendarz imienin
*
* @author rp@sote.pl
*/
require_once("include/nameday_array.inc.php");
class NameDay extends NameDayArray {
    
    var $month;     // aktualny miesiac
    var $day;       // aktualy dzien
    var $name;      // lista imienin z aktualnego dnia

    /*
    * Konstruktor
    */
    function NameDay(){
        
        $this->month=date("n");
        $this->day=date("j");        
        $this->name=$this->name_day[$this->month][$this->day];        
        
        return;
    } // end NameDay()
    
    /**
    * @desc wyswietla liste solenizantow
    *
    * @access public
    * @return void    
    */
    function showNameDay(){
        
        print $this->name;
        
        return;
    } // end showNameDay()
    
} // end NameDay

$name_day=&New NameDay;
$name_day->showNameDay();
?>
