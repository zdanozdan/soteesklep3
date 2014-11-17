<?php
/**
 * Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
 *
 * \@global object $result - wynik zapytania SQL o wlasciwosci produktu
* @version    $Id: query_rec.inc.php,v 2.3 2004/12/20 18:01:46 maroslaw Exp $
* @package    register
 */

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Niedozwolone wywolanie");
}

class RecordData {
    var $data=array();
}

$rec = new RecordData;

$i=0;
$rec->data['id']=$db->FetchResult($result,$i,"id");
$rec->data['order_id']=$db->FetchResult($result,$i,"order_id");
$rec->data['session_id']=$db->FetchResult($result,$i,"session_id");
$rec->data['amount']=$db->FetchResult($result,$i,"amount");
$rec->data['delivery_cost']=$db->FetchResult($result,$i,"delivery_cost");
$rec->data['id_pay_method']=$db->FetchResult($result,$i,"id_pay_method");
$rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
$rec->data['time_add']=$db->FetchResult($result,$i,"time_add");
$rec->data['remote_ip']=$db->FetchResult($result,$i,"remote_ip");
$rec->data['crypt_email']=$db->FetchResult($result,$i,"crypt_email");
$rec->data['crypt_xml_description']=$db->FetchResult($result,$i,"crypt_xml_description");
$rec->data['id_user']=$db->FetchResult($result,$i,"id_user");
$rec->data['crypt_xml_user']=$db->FetchResult($result,$i,"crypt_xml_user");
$rec->data['crypt_name']=$db->FetchResult($result,$i,"crypt_name");
$rec->data['id_delivery']=$db->FetchResult($result,$i,"id_delivery");
$rec->data['id_status']=$db->FetchResult($result,$i,"id_status");
$rec->data['confirm']=$db->FetchResult($result,$i,"confirm");
$rec->data['checksum']=$db->FetchResult($result,$i,"checksum");
$rec->data['confirm_user']=$db->FetchResult($result,$i,"confirm_user");
$rec->data['description']=$db->FetchResult($result,$i,"description");
$rec->data['send_confirm']=$db->FetchResult($result,$i,"send_confirm");
$rec->data['send_date']=$db->FetchResult($result,$i,"send_date");
$rec->data['send_number']=$db->FetchResult($result,$i,"send_number");
$rec->data['confirm_online']=$db->FetchResult($result,$i,"confirm_online");
?>
