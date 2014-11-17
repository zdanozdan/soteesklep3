<?php
/**
 * PHP Template
 * 
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author m@sote.pl
 * \@template_version Id: form_check_functions.inc.php,v 2.2 2003/05/15 13:47:56 scalak Exp
 * @version $Id: form_check_functions.inc.php,v 1.5 2006/05/08 12:38:40 lechu Exp $
 * @return int $this->id
* @package    discounts
* @subpackage discounts_groups
 */

global $database;
require_once ("include/metabase.inc");

class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
    
    var $start_date;    // data i godzina poczatku promocji
    var $end_date;      // data i godzina konca promocji
    
    /**
     * Sprawdz pole user_id
     *
     * @param string $user_id id grupy
     * @return bool true      OK, false - bledna wartosc
     * @return int  10        taka wartosc juz istnieje
     */
    function user_id($user_id) {
        global $database;

        if ($user_id==0) {
            $this->error_nr=10;
            return false;   
        }     

        if (! ereg("^[0-9]+$",$user_id)) {
            $this->error_nr=1;
            return false;
        }

        // sprawdz czy takie pole istnieje juz w bazie
        $my_user_id=$database->sql_select("user_id","discounts_groups","user_id=$user_id");
        if (! empty($my_user_id)) {
            $this->error_nr=2;
            return false;
        }
        
        return true;
    } // end user_id()

    /**
     * Sprawdz pole start_date, format (2003-10-09;09:55 itp.) 
     *
     * @param string $date   data poczatkowa 
     * @return bool true     OK, false - bledna wartosc
     */
    function start_date($date) {
        global $database;

        $this->start_date=$date;

        // pobierz aktualna date
        $my_date=date("Y-m-d");

        // pobierz aktualny czas
        $my_time=date("H:i");

        // jesli ktos wpisze 0 lub nic - promocja nieaktywna
        if (empty($date)) {
            return true;
        }
        
        // zly format danych
        if (! eregi("^[0-9]{4}-[0-9]{2}-[0-9]{2};[0-9]{2}:[0-9]{2}$",$date)) {
            $this->error_nr=2;
            return false; 
        }

        // rozbijam dane na date i godzine
        $my_data=split(";",$date);
        
        // data poczatku promocji
        $start_date=$my_data[0];

        // godzina poczatku promocji
        $start_time=$my_data[1];

        // zly format daty
        if (! eregi("^[0-9]{4}-[0-9]{2}-[0-9]{2}$",$start_date)) {
            $this->error_nr=3;
            return false; 
        }
        
        // rozbij date na dzien, miesiac, rok
        $splitted_date=split("-",$start_date);
        
        $year=$splitted_date[0];
        $month=$splitted_date[1];
        $day=$splitted_date[2];
        
        // sprawdz rok
        $year_array=array("2003","2004","2005","2006","2007","2008","2009","2010");
        if (! in_array($year,$year_array)) {
            $this->error_nr=5;
            return false; 
        }

        // sprawdz miesiac
        if (($month<=0) || ($month>12)) {
            $this->error_nr=6;
            return false; 
        }

        // sprawdz dzien
        if (($day<=0) || ($day>31)) {
            $this->error_nr=7;
            return false; 
        }

        // rozbijam czas poczatku promocji na godziny i minuty
        $splitted_start_time=split(":",$start_time);
        
        // godzina poczatku promocji
        $start_hour=$splitted_start_time[0];
        
        // minuta poczatku promocji
        $start_minute=$splitted_start_time[1];
        
        
        // zly format godziny
        if (($start_hour<0) || ($start_hour>23)) {
            $this->error_nr=8;
            return false; 
        }
        
        // zly format minuty
        if (! eregi("^[0-5][0-9]$",$start_minute)) {
            $this->error_nr=9;
            return false; 
        }

        // data rozpoczecia musi byc pozniesza niz aktualna data
        if ($start_date<$my_date) {
            $this->error_nr=4;
            return false;
        }
        if ($start_date == $my_time) {
            // czas rozpoczecia musi byc poznieszy niz aktualny czas
            if ($start_time<$my_time) {
                $this->error_nr=10;
                return false;
            }
        }
        
        return true;
    } // end start_date()

    /**
     * Sprawdz pole end_date format (2003-10-09;13:53 itp.) 
     *
     * @param string $date   data koncowa promocji 
     * @return bool true     OK, false - bledna wartosc
     */
    function end_date($date) {
        global $database;

        $this->end_date=$date;

        // pobierz aktualna date
        $my_date=date("Y-m-d");

        // pobierz aktualny czas
        $my_time=date("H:i");

        // jesli ktos wpisze 0 lub nic - promocja nieaktywna
        if (empty($date)) {
            return true;
        }
        
        // zly format danych
        if (! eregi("^[0-9]{4}-[0-9]{2}-[0-9]{2};[0-9]{2}:[0-9]{2}$",$date)) {
            $this->error_nr=2;
            return false; 
        }

        // rozbijam dane na date i godzine
        $my_data=split(";",$date);
        
        // data poczatku promocji
        $start_date=$my_data[0];

        // godzina poczatku promocji
        $start_time=$my_data[1];

        // zly format daty
        if (! eregi("^[0-9]{4}-[0-9]{2}-[0-9]{2}$",$start_date)) {
            $this->error_nr=3;
            return false; 
        }
        
        // rozbij date na dzien, miesiac, rok
        $splitted_date=split("-",$start_date);
        
        $year=$splitted_date[0];
        $month=$splitted_date[1];
        $day=$splitted_date[2];
        
        // sprawdz rok
        $year_array=array("2003","2004","2005","2006","2007","2008","2009","2010");
        if (! in_array($year,$year_array)) {
            $this->error_nr=6;
            return false; 
        }

        // sprawdz miesiac
        if (($month<=0) || ($month>12)) {
            $this->error_nr=7;
            return false; 
        }

        // sprawdz dzien
        if (($day<=0) || ($day>31)) {
            $this->error_nr=8;
            return false; 
        }

        // rozbijam czas poczatku promocji na godziny i minuty
        $splitted_start_time=split(":",$start_time);
        
        // godzina poczatku promocji
        $start_hour=$splitted_start_time[0];
        
        // minuta poczatku promocji
        $start_minute=$splitted_start_time[1];
        
        
        // zly format godziny
        if (($start_hour<0) || ($start_hour>23)) {
            $this->error_nr=9;
            return false; 
        }
        
        // zly format minuty
        if (! eregi("^[0-5][0-9]$",$start_minute)) {
            $this->error_nr=10;
            return false; 
        }
        
        // data konca musi byc pozniesza niz data poczatku promocji
        if ($this->start_date>=$this->end_date) {
            $this->error_nr=5;
            return false;
        }
        
/*
        // czas rozpoczecia musi byc poznieszy niz aktualny czas
        if ($start_time<$my_time) {
            $this->error_nr=11;
            return false;
        }
*/
        return true;
    } // end end_date()

} // end class FormCheckFunctions
?>
