<?php
/**
 * Testowy plik do sprwadzenia porownywania baz danych
 *
 * @author r@sote.pl
 * @version $Id: example.php,v 1.1 2004/07/01 08:54:37 scalak Exp $
 * @package setup
 */

$global_database=true; // wylaczenie podwojnego sprawdzania autoryzacji
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("$DOCUMENT_ROOT/../include/head.inc");
require_once ("./include/db_compare.inc.php");

// naglowek
$theme->theme_file("head_setup.html.php");

$compare = new DatabaseComapre();
$compare->SetStatus("old","file");
$compare->SetStatus("new","file");
$compare->SetDbName("old","soteesklep2");
$compare->SetDbName("new","soteesklep3");
$data=$compare->action();

$theme->theme_file("foot_setup.html.php");
// stopka
include_once ("include/foot.inc");
?>