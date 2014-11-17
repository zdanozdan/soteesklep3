<?php
/**
* @version    $Id: status.php,v 1.3 2005/01/20 14:59:56 maroslaw Exp $
* @package    main_keys
* @subpackage offline
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
// $Id: status.php,v 1.3 2005/01/20 14:59:56 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->offline_status);

// zapisz dane w pliku sesji, dane sesyjne przekazywane do skryptow w Perlu
require_once ("./include/status.inc.php");
require_once ("./html/status.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
