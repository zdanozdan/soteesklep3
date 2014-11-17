<?php
/**
* Raporty sprzeda¿y produktów
*
* Domy¶lny skrypt obs³uguj±cy generowanie raportów sprzeda¿y.
* Inicjuje obiekt klasy Report, za³±cza odpowiednie pliki modu³u i wykonuje jego metody.
* @author  lech@sote.pl
* @version $Id: producers.php,v 1.5 2005/01/20 14:59:39 maroslaw Exp $
* @package    report
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
global $config;

/**
* Nag³ówek skryptu
*/
require_once ("../../../include/head.inc");



$theme->head();
$theme->page_open_head();

/**
* Podmenu strony modu³u
*/
include_once ("./include/menu.inc.php"); // menu 

/**
* Plik z definicj± klasy Report
*/
include_once ("./include/report.inc.php"); // menu 
$theme->bar($lang->report_bar);            // bar 

echo "<br>";

$report =& new Report(@$_REQUEST['report']);
$report->draw();

$theme->page_open_foot();
$theme->foot();

/**
* Stopka skryptu
*/
include_once ("include/foot.inc");

?>
