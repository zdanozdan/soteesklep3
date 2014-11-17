<?php
/**
* Raporty sprzeda�y produkt�w
*
* Domy�lny skrypt obs�uguj�cy generowanie raport�w sprzeda�y.
* Inicjuje obiekt klasy Report, za��cza odpowiednie pliki modu�u i wykonuje jego metody.
* @author  lech@sote.pl
* @version $Id: producers.php,v 1.5 2005/01/20 14:59:39 maroslaw Exp $
* @package    report
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
global $config;

/**
* Nag��wek skryptu
*/
require_once ("../../../include/head.inc");



$theme->head();
$theme->page_open_head();

/**
* Podmenu strony modu�u
*/
include_once ("./include/menu.inc.php"); // menu 

/**
* Plik z definicj� klasy Report
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
