<?php
/**
 * Optymalizacja danych, listy producentow w kategoriach
 * Skrypt jest wywolywany bez obslugi sesji, gdyz wymagane jest przesylanie strumieniowe.
 *
 * @author  m@sote.pl
 * @version $Id: producers.php,v 2.6 2005/06/08 11:22:39 maroslaw Exp $
* @package    opt
 */

$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../include/head_stream.inc.php");

// dodaj obsluge FTP
require_once ("include/ftp.inc.php");

// naglowek
$theme->head_window();
$theme->bar($lang->bar_title['opt']);

// obsluga streamingu -> status bar
require_once ("themes/stream.inc.php");
$stream = new StreamTheme;
$stream->title_500(); // wyswietl pasek z numerami 100,200,300,400,500

$ftp->connect();

// odczytaj liste producentow do kategorii i zapisz dane w pliku config/tmp/producer.php
if (in_array("producer_list",$config->plugins)) {
    require_once ("./include/producer.inc.php");
}

$ftp->close();

print "<center>".$lang->opt_producers_ok."</center><p>";


// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
