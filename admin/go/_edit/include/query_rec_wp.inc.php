<?php
/**
* Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
*
* @author  m@sote.pl
* @version $Id: query_rec_wp.inc.php,v 2.2 2004/12/20 17:58:05 maroslaw Exp $
*
* \@global object $result           wynik zapytania SQL o wlasciwosci produktu
* \@global string $_REQUEST['lang'] jêzyk, dla którego jest definiowany opis itp.
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Forbidden");
}

require_once ("include/price.inc");
$my_price = new MyPrice;

class RecordData {
    var $data=array();
}

global $rec;
$rec =& new RecordData;

$i=0;
$rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
$rec->data['wp_export']=$db->FetchResult($result,$i,"wp_export");
$rec->data['wp_status']=$db->FetchResult($result,$i,"wp_status");
$rec->data['wp_dictid']=$db->FetchResult($result,$i,"wp_dictid");
$rec->data['wp_category']=$db->FetchResult($result,$i,"wp_category");
$rec->data['wp_producer']=$db->FetchResult($result,$i,"wp_producer");
$rec->data['wp_advantages']=$db->FetchResult($result,$i,"wp_advantages");
$rec->data['wp_filters']=$db->FetchResult($result,$i,"wp_filters");
$rec->data['wp_dest']=$db->FetchResult($result,$i,"wp_dest");
$rec->data['wp_ptg']=$db->FetchResult($result,$i,"wp_ptg");
$rec->data['wp_ptg_desc']=$db->FetchResult($result,$i,"wp_ptg_desc");
$rec->data['wp_ptg_days']=$db->FetchResult($result,$i,"wp_ptg_days");
$rec->data['wp_ptg_picurl']=$db->FetchResult($result,$i,"wp_ptg_picurl");
$rec->data['wp_valid']=$db->FetchResult($result,$i,"wp_valid");
?>
