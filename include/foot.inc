<?php
/**
 * Stopka. Pliki wywolywany przy kazdej odslonie strony sklepu.
 *
 * @author  m@sote.pl
 * @version $Id: foot.inc,v 2.23 2006/05/19 07:20:51 lukasz Exp $
* @package    include
 */

// Koniec pomiaru czasu, zapisz wynik w pliku 
$endTime=split(" ",microtime());
$endTime=$endTime[1]+$endTime[0];
if (empty($startTime)) $startTime=$endTime;
$execute_time=($endTime-$startTime)."\n";
$execute_time=number_format($execute_time,4,'','');

// time debug
// print "<center><font size=-1>$lang->time_execute: $execute_time s</font></center>";
// print $time->show();
global $google;
if ($google->changeTheme()=="google") {
    $gl=rand(0,sizeof($config->sign_keys)-1);
}
?>
