<?php
/**
* Skrypt wy¶wietla listê transakcji, wg zdefiniowanego zapytania SQL.
*
* @author  m@sote.pl
* @version $Id: order_list.inc.php,v 2.9 2005/12/14 08:14:06 lechu Exp $
*
* \@global string $sql       zapytanie SQL listy transakcji
* \@global int    $__no_head 1 - poka¿ uproszczony nag³ówek i stopkê, nie pokazuj menu itp.
* @package    order
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");
require_once ("./include/order_func.inc.php");

// przekaz nazwy statusow wg id do obiektu $config
$status_names=read_status_names();
$config->order_status=$status_names;
global $__no_head;
if(!empty($_REQUEST['print_mode'])) { // prezentacja listy do wydruku
	$__no_head = 1;
	global $_print_mode;
	$_print_mode=true;
}
	
// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
if (@$__no_head!=1) {
    $theme->head();
    $theme->page_open_head();
} else {
    $theme->head_window();   
}

// menu z linkami (wyszukianie, lista transkacji itp)
if (@$__no_head!=1 || !@$_print_mode) {
	include_once("./include/menu.inc.php");
}

if (empty($sql)) {
    $sql="SELECT * FROM order_register WHERE record_version='30' ORDER BY id DESC";   
}
// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

if (@$__no_head!=1 || !@$_print_mode) {
	$theme->bar($lang->bar_title['order']);
}
else {
	echo "<center><b>" . $lang->order_list_title . "</b>";
}

$dbedit = new DBEditList;
$dbedit->page_records=50;
$dbedit->page_links=50;

// ustal klase i funkcje generujaca wiersz rekordu
require_once("./include/order_record.inc.php");
require_once ("./include/list_th.inc.php");
$dbedit->start_list_element=order_list_th();
$dbedit->record_class="OrderRecordRow";
$dbedit->record_fun="record";

print "<form action=/go/_order/delete.php method=post name=FormOrder>";
$dbedit->show();
print "</form>";

/**
* Dodaj obs³ugê raportów na podstawie zapyatania SQL
*/
require_once ("./include/report.inc.php");
$report =& new OrderReport($sql);
$report->showHTMLReport();

$theme->legend();

if (@$__no_head!=1) {
    $theme->page_open_foot();
    $theme->foot();
} else {
    $theme->foot_window();   
}

if (@$__no_head==1 && $_print_mode) {
	echo "
	<script>
	window.print();
	</script>
	";
}

include_once ("include/foot.inc");
?>
