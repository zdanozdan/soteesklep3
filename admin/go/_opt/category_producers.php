<?php
/**
 * Optymalizacja danych, aktualizacja kategorii i listy producentow w kategoriach
 * Skrypt jest wywolywany bez obslugi sesji, gdyz wymagane jest przesylanie strumieniowe.
 *
 * @author  m@sote.pl
 * @version $Id: category_producers.php,v 1.1 2008/08/11 16:42:17 tomasz Exp $
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
// aktualizuj kategorie
require_once ("./include/db2category.inc.php");
$db2c = new DB2Category;
$db2c->optimize();

require_once ("./include/category2treeview.inc.php");
$treeview = new Treeview;
$treeview->update_category_files();

// odczytaj liste producentow do kategorii i zapisz dane w pliku config/tmp/producer.php
if (in_array("producer_list",$config->plugins)) {
    require_once ("./include/producer.inc.php");
}

// generuj liste kategorii dla producentow
if (in_array("producers_category",$config->plugins)) {
    include_once ("./include/producers_category.inc.php");
}

$ftp->close();

print "<center>".$lang->opt_ok."</center><p>";

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
