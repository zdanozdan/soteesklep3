<?php
/**
 * Klasa zawierajaca funckje zwiazane z pomiarem czasu wykonywania skryptu
 *
 * @author  m@sote.pl
 * @version $Id: time.inc,v 2.2 2004/12/20 18:02:57 maroslaw Exp $
* @package    include
 */

class Time {

    var $start_tab=array();  // tablica z poczatkami pomiaru czasu
    var $times=array();      // czasy wykonania skryptu dla poszczegolnych etykiet

    /**
     * Zaznacz odmierzanie czas dla etykiety $name
     *
     * @param string $name etykieta pomiaru czasu
     * @return
     * \@global float $this->start_time[$name]
     */
    function start($name="time") {
        $startTime=split(" ",microtime());
        $startTime=$startTime[1]+$startTime[0];
        $this->start_tab[$name]=$startTime;
        return(0);
    } // end start()
    
    /**
     * Zakoncz odmierzanie czasu dla etykiety $name
     *
     * @param string $name etykieta pomiaru czasu
     * @return 
     * \@global float $this->stop_time[$name]
     * @return int   1 - nie ma poczatkowego czasu dla etykiety $name
     */
    function stop($name="time") {
        if (! empty($this->start_tab[$name])) {
            $startTime=$this->start_tab[$name];
        } else return (1);

        $endTime=split(" ",microtime());
        $endTime=$endTime[1]+$endTime[0];
        $execute_time=($endTime-$startTime)."\n";
        $execute_time=number_format($execute_time,6,'','');
        $this->times[$name]=$execute_time;

        return(0);
    } // end stop()

    /**
     * Pokaz zestawienie pomiarow
     */
    function show($name="all") {
        if ($name=="all") {
            print "<table border=1>\n";
            while (list($name,$time) = each ($this->times)) {
                print "\t<tr><td>$name</td><td>$time</td></tr>\n";
            }
            print "</table>\n";
        } else {
            if (! empty($this->times[$name])) {
                $time=$this->times[$name];
                print "<li>$name: $time <BR>";
            } else return 1;
        }
    } // end show()

} // end class Time

$time = new Time;

?>
