<?php
/**
 * Aktualizuj cennik, zapisz dane do bazy, generuj raport aktualizacji
 * Skrypt jest wywolywany bez obslugi sesji, gdyz wymagane jest przesylanie strumieniowe.
 *
 * @author  piotrek@sote.pl
 * @version $Id: offline.php,v 1.7 2005/06/08 11:22:36 maroslaw Exp $
* @package    offline
* @subpackage attributes
 */

$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head_stream.inc.php");

// naglowek
$theme->head_window();

$theme->bar($lang->offline_update);

// odczytujemy tryb pracy offline
if (! empty($_REQUEST['money_mode'])) {
    $money_mode=$_REQUEST['money_mode'];
} else  die ("Forbidden");

$theme->theme_file("_offline/offline_1.html.php");

include_once ("./include/offline.inc.php");

$theme->foot_window();

include_once ("include/foot.inc");
?>
