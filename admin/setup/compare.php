<?php
/**
 * Testowy plik do sprwadzenia porownywania baz danych
 *
 * @author r@sote.pl
 * @version $Id: compare.php,v 2.6 2005/01/20 15:00:12 maroslaw Exp $
* @package    setup
 */

$global_database=true; // wylaczenie podwojnego sprawdzania autoryzacji
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head.inc");
require_once ("lib/Compare/db_compare.inc.php");

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");

$compare = new DatabaseComapre();
$compare->SetStatus("old","db");
$compare->SetStatus("new","db");
$compare->SetDbName("old","soteesklep4");
$compare->SetDbName("new","soteesklep2");
$data=$compare->action();


include_once ("themes/base/base_theme/foot_setup.html.php");
// stopka
include_once ("include/foot.inc");
?>
