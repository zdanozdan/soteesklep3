<?php
/**
 * Wy¶wietl formularz do zalaczenia pliku cennika
 *
 * @author  rdiak@sote.pl
 * @version $Id: export.php,v 1.7 2005/06/08 11:22:39 maroslaw Exp $
* @package    offline
* @subpackage export
 */

$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu do strumieniowego przesylania danych na ekran
 */
require_once ("../../../include/head_stream.inc.php");

/**
 * Odczytanie konfiguracji
 */
include_once ("$DOCUMENT_ROOT/go/_offline/_main/config/config.inc.php");

// naglowek
$theme->head_window();

$theme->bar($lang->export_update);

include_once ("./include/export.inc.php");
$export=new OfflineExport;
$export->action();

$theme->foot_window();

include_once ("include/foot.inc");
?>
