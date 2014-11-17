<?php
/**
* Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
*
* @author  m@sote.pl
* @version $Id: query_rec_interia.inc.php,v 2.1 2005/03/29 15:17:35 scalak Exp $
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
$rec->data['interia_export']=$db->FetchResult($result,$i,"interia_export");
$rec->data['interia_status']=$db->FetchResult($result,$i,"interia_status");
$rec->data['interia_category']=$db->FetchResult($result,$i,"interia_category");
?>
