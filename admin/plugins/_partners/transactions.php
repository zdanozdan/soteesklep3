<?php
/**
 * Wyswietlanie transakcji zawartych po przekierowniu ze stron partnerow
 * 
 * @author piotrek@sote.pl
 * @version $Id: transactions.php,v 1.6 2005/01/20 15:00:02 maroslaw Exp $
* @package    partners
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");
require_once ("include/metabase.inc");
require_once ("./include/order_func.inc.php");

// przekaz nazwy statusow wg id do obiektu $config
$status_names=read_status_names();
$config->order_status=$status_names;

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

// wstaw liste sortowania tabeli main
include_once ("./include/order_register.inc.php");

$sql="SELECT * FROM order_register WHERE partner_id!=0 ";

// menu z linkami (wyszukianie, lista transkacji itp)
include_once("./include/menu.inc.php");

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

$theme->bar($lang->bar_title['order']);

print "<BR>";

$dbedit = new DBEditList;
$dbedit->page_records=20;
$dbedit->page_links=20;

// ustal klase i funkcje generujaca wiersz rekordu
require_once("./include/order_record.inc.php");
$dbedit->start_list_element=$theme->order_list_th();
$dbedit->record_class="OrderRecordRow";
$dbedit->record_fun="record";

$dbedit->show();
print "</form>";


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
