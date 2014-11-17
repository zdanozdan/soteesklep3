<?php
/**
* Aktualizacja hasla FTP, formularz
*
* Skrypt ten jest wywo³ywany w sklpie, je¶li has³o FTP zapisane
* 2 pliku konfiguracyjnym siê nie zgadza.
*
* @author  m@sote.pl
* @version $Id: ftp.php,v 2.5 2005/01/20 15:00:13 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->setup_ftp_change);

print "<p>\n";
include_once ("./html/ftp.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
