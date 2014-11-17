<?php
/**
 * Obliczanie prowizji dla danego partnera z zadanego okresu czasu
 * 
 * @author piotrek@sote.pl
 * @version $Id: rake_off.php,v 1.5 2005/01/20 15:00:02 maroslaw Exp $
* @package    partners
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/date.inc.php");
require_once ("include/metabase.inc");
require_once ("./include/rake_off.inc.php");
global $database;
// end naglowek php

// sprawdzam czy sa jakies rekordy w tabeli partners
$check=$database->sql_select("id","partners","");

$my_date = new DateFormElements;  // definicja klasy odpowiedzialnej za wyswietlanie daty
$rake_off = new RakeOff;          // definicja klasy odpowiedzialnej za obliczenie prowizji

$theme->head();
$theme->page_open_head();

include("include/menu.inc.php");  // dolacz menu

// naglowek
$theme->bar($lang->partners_rake_off);

print "<BR><BR>";

if (! empty($check)) {
    include("html/rake_off.html.php");
    
    if((! empty($_REQUEST['item']['partner_name'])) && (! empty($_REQUEST['from']['day'])) && (! empty($_REQUEST['to']['day']))) {
        $partner=$_REQUEST['item']['partner_name'];            // numer partnera w tablicy $data 
        $partner=$data[$partner];                              // zamien numer na nazwe partnera
        $from_day=$_REQUEST['from']['day'];                    // od dzien 
        if ($from_day<10) $from_day="0$from_day";              // jesli dzien<10 dodaj 0 do liczby w celu zachowania zgodnosci formatu
        $from_month=$_REQUEST['from']['month'];                // od miesiac
        if ($from_month<10) $from_month="0$from_month";        // jesli miesiac<10 dodaj 0 do liczby w celu zachowania zgodnosci formatu
        $from_year=$_REQUEST['from']['year'];                  // od rok
        $to_day=$_REQUEST['to']['day'];                        // do dzien 
        if ($to_day<10) $to_day="0$to_day";                    // jesli dzien<10 dodaj 0 do liczby w celu zachowania zgodnosci formatu
        $to_month=$_REQUEST['to']['month'];                    // do miesiac
        if ($to_month<10) $to_month="0$to_month";              // jesli miesiac<10 dodaj 0 do liczby w celu zachowania zgodnosci formatu
        $to_year=$_REQUEST['to']['year'];                      // do rok
        $from_date=$from_year."-".$from_month."-".$from_day;   // zloz prawidlowy format daty od
        $to_date=$to_year."-".$to_month."-".$to_day;           // zloz prawidlowy format daty do
        
        // oblicz prowizje dla wybranego partnera i zdefinowanego okresu
        $rake_off->compute_rake_off($partner,$from_date,$to_date);
    }
} else print "<b>$lang->partners_attention</b><BR>$lang->partners_no_records_rake";  // w przeciwnym wypadku pokaz komunikat o braku rek.
    
$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
