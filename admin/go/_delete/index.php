<?php
/**
 * Usun rekordy z tabeli main (produkty)
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 2.4 2005/01/20 14:59:19 maroslaw Exp $
 * @package soteesklep
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("./include/delete.inc.php");
require_once ("include/ftp.inc.php");

// naglowek
if (@$_REQUEST['no_head_foot']!=1) {
    $theme->head();
    $theme->page_open_head();
}

if (! empty($_REQUEST['del'])) {
    $del=$_REQUEST['del'];
    // lista produktow do usuniecia
    while (list($id,) = each($del)) {
        if (! empty($id)) {
            $delete->delete($id);
        }
    }
    $ftp->close(); // zamknij polaczenie ftp, jesli zostalo zainicjowane przy usuwaniu pliku html z opisem do produktu
} else {
    print "<center>".$lang->delete_empty."</center>";
}

if (@$_REQUEST['no_head_foot']!=1) {
    $theme->page_open_foot();

    // stopka
    $theme->foot();
}

include_once ("include/foot.inc");
?>
