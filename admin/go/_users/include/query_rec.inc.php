<?php
/**
 * Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
 *
 * \@global object $result - wynik zapytania SQL o wlasciwosci produktu
* @version    $Id: query_rec.inc.php,v 2.11 2006/01/30 14:57:16 krzys Exp $
* @package    users
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
$rec->data['crypt_login']=$db->Fetchresult($result,$i,"crypt_login");

$rec->data['crypt_firm']=$db->FetchResult($result,$i,"crypt_firm");
$rec->data['crypt_name']=$db->FetchResult($result,$i,"crypt_name");
$rec->data['crypt_surname']=$db->FetchResult($result,$i,"crypt_surname");
$rec->data['crypt_email']=$db->FetchResult($result,$i,"crypt_email");
$rec->data['crypt_street']=$db->FetchResult($result,$i,"crypt_street");
$rec->data['crypt_street_n1']=$db->FetchResult($result,$i,"crypt_street_n1");
$rec->data['crypt_street_n2']=$db->FetchResult($result,$i,"crypt_street_n2");
$rec->data['crypt_postcode']=$db->FetchResult($result,$i,"crypt_postcode");
$rec->data['crypt_city']=$db->FetchResult($result,$i,"crypt_city");
$rec->data['crypt_country']=$db->FetchResult($result,$i,"crypt_country");
$rec->data['crypt_phone']=$db->FetchResult($result,$i,"crypt_phone");
$rec->data['crypt_nip']=$db->FetchResult($result,$i,"crypt_nip");
$rec->data['crypt_user_description']=$db->FetchResult($result,$i,"crypt_user_description");

$rec->data['crypt_cor_firm']=$db->FetchResult($result,$i,"crypt_cor_firm");
$rec->data['crypt_cor_name']=$db->FetchResult($result,$i,"crypt_cor_name");
$rec->data['crypt_cor_surname']=$db->FetchResult($result,$i,"crypt_cor_surname");
$rec->data['crypt_cor_email']=$db->FetchResult($result,$i,"crypt_cor_email");
$rec->data['crypt_cor_street']=$db->FetchResult($result,$i,"crypt_cor_street");
$rec->data['crypt_cor_street_n1']=$db->FetchResult($result,$i,"crypt_cor_street_n1");
$rec->data['crypt_cor_street_n2']=$db->FetchResult($result,$i,"crypt_cor_street_n2");
$rec->data['crypt_cor_postcode']=$db->FetchResult($result,$i,"crypt_cor_postcode");
$rec->data['crypt_cor_city']=$db->FetchResult($result,$i,"crypt_cor_city");
$rec->data['crypt_cor_country']=$db->FetchResult($result,$i,"crypt_cor_country");
$rec->data['crypt_cor_phone']=$db->FetchResult($result,$i,"crypt_cor_phone");
$rec->data['sales']=$db->FetchResult($result,$i,"id_sales");
$rec->data['limits']=$db->FetchResult($result,$i,"limits");
$rec->data['remark_admin']=$db->FetchResult($result,$i,"remark_admin");

// blokada uzytkownika
$rec->data['lock_user']=$db->FetchResult($result,$i,"lock_user");

// sprawd¼ czy dane dotycz± zarejestrowanego klienta, czy s± to dane do zamówienia
$rec->data['id_users_data']=$db->FetchResult($result,$i,"id_users_data");

// sprawd¼, czy dane klienta dotycz± kleinta zarejestrowanego, czy danych do transakcji
$rec->data['order_data']=$db->FetchResult($result,$i,"order_data");

$rec->data['hurt']=$db->FetchResult($result,$i,"hurt");
if ( empty($rec->data['hurt'])) {
    $rec->data['hurt']=0;
}

// grupa rabatowa
$rec->data['id_discounts_groups']=$db->FetchResult($result,$i,"id_discounts_groups");

// odczytaj liczbe punktow uzytkownika
$global_id_user=$id;
require_once("./include/get_points.inc.php");
$rec->data['points']=$global_points;

?>
