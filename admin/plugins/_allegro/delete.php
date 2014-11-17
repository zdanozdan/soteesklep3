<?php
// +----------------------------------------------------------------------+
// | SOTEeSKLEP version 2                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1999-2002 SOTE www.sote.pl                             |
// +----------------------------------------------------------------------+
// | Usuniecie wybranych rekordow                                         |
// +----------------------------------------------------------------------+
// | authors:     Marek Jakubowicz <m@sote.pl> (base system)              |
// +----------------------------------------------------------------------+
//
// $Id: delete.php,v 1.2 2006/04/20 09:14:57 scalak Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("./include/delete.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->allegro_bar["delete"]);

print "<p>";

if (! empty($_REQUEST['del'])) {
    $del=$_REQUEST['del'];
    // lista produktow do usuniecia
    while (list($id,) = each($del)) {
        if (! empty($id)) {
            $delete->delete($id);
        }
    }
} else {
    print "<center>".$lang->delete_empty."</center>";
}


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
