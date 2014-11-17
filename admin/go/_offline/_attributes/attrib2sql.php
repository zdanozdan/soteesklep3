<?php
/**
* @version    $Id: attrib2sql.php,v 1.4 2005/01/20 14:59:26 maroslaw Exp $
* @package    offline
* @subpackage attributes
*/
// +----------------------------------------------------------------------+
// | SOTEeSKLEP version 2                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1999-2002 SOTE www.sote.pl                             |
// +----------------------------------------------------------------------+
// | Aktualizacja off-line - zaladowanie cennnika z Excela, Accessa itp.  |
// +----------------------------------------------------------------------+
// | authors:     Marek Jakubowicz <m@sote.pl> (base system)              |
// +----------------------------------------------------------------------+
//
// $Id: attrib2sql.php,v 1.4 2005/01/20 14:59:26 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");

// bar = true juz wyswietlono bar
if (empty($bar)) {
    $theme->bar($lang->offline_update_now);
}
// zapisz dane w pliku sesji, dane sesyjne przekazywane do skryptow w Perlu
require_once ("../include/save_cgi_session.inc.php");
require_once ("./html/attrib.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
