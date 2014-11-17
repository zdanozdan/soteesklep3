<?php
/**
* Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
*
* @author  m@sote.pl
* @version $Id: query_rec.inc.php,v 2.33 2006/01/30 15:03:00 krzys Exp $
* @package    order
*/

/**
* \@global object $result - wynik zapytania SQL o wlasciwosci produktu
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Forbidden");
}

require_once ("include/order_register.inc");
require_once ("Date/Calc.php");
require_once ("include/my_crypt.inc");

/**
* Klasa pomocnicza
* @package order
* @subpackage order
* @ignore
*/
class RecordData {
    var $data=array();
}

$rec =& new RecordData;

$i=0;
$rec->data['id']=$db->FetchResult($result,$i,"id");
$rec->data['order_id']=$db->FetchResult($result,$i,"order_id");
$rec->data['session_id']=$db->FetchResult($result,$i,"session_id");

$rec->data['amount']=$theme->price($db->FetchResult($result,$i,"amount"));
$rec->data['delivery_cost']=$db->FetchResult($result,$i,"delivery_cost");

// kwota do zaplaty (wliczony jest koszt dostawy)
$rec->data['amount_all']=$rec->data['amount']+$rec->data['delivery_cost'];
$rec->data['amount_confirm']=$db->FetchResult($result,$i,"amount_confirm");
if ($rec->data['amount_confirm']>0) {
    $rec->data['amount_confirm']=$db->FetchResult($result,$i,"amount_confirm");
} else {
    $rec->data['amount_confirm']=$rec->data['amount_all'];
}

$rec->data['id_pay_method']=$db->FetchResult($result,$i,"id_pay_method");
$rec->data['pay_status']=$db->FetchResult($result,$i,"pay_status");
$rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
$rec->data['time_add']=$db->FetchResult($result,$i,"time_add");
$rec->data['remote_ip']=$db->FetchResult($result,$i,"remote_ip");
$rec->data['id_users']=$db->FetchResult($result,$i,"id_users");
$rec->data['id_delivery']=$db->FetchResult($result,$i,"id_delivery");
$rec->data['id_status']=$db->FetchResult($result,$i,"id_status");
$rec->data['confirm']=$db->FetchResult($result,$i,"confirm");
$rec->data['cancel']=$db->FetchResult($result,$i,"cancel");
$rec->data['confirm_online']=$db->FetchResult($result,$i,"confirm_online");
$rec->data['checksum']=$db->FetchResult($result,$i,"checksum");
$rec->data['checksum_online']=$db->FetchResult($result,$i,"checksum_online");
$rec->data['confirm_user']=$db->FetchResult($result,$i,"confirm_user");
$rec->data['description']=$db->FetchResult($result,$i,"description");
$rec->data['send_date']=$db->FetchResult($result,$i,"send_date");
$rec->data['send_number']=$db->FetchResult($result,$i,"send_number");
$rec->data['send_confirm']=$db->FetchResult($result,$i,"send_confirm");
$rec->data['partner_id']=$db->FetchResult($result,$i,"partner_id");
$rec->data['confirm_partner']=$db->FetchResult($result,$i,"confirm_partner");
$rec->data['partner_name']=$db->FetchResult($result,$i,"partner_name");
$rec->data['rake_off_amount']=$db->FetchResult($result,$i,"rake_off_amount");
$rec->data['fraud']=$db->FetchResult($result,$i,"fraud");
$rec->data['error']=$db->FetchResult($result,$i,"error");
$rec->data['error_desc']=$db->FetchResult($result,$i,"error_desc");
$rec->data['recom_id_user']=$db->FetchResult($result,$i,"recom_id_user");
$rec->data['id_card_pay']=$db->FetchResult($result,$i,"id_card_pay");
$rec->data['info_for_client']=$db->FetchResult($result,$i,"info_for_client");

$rec->data['points']=$db->FetchResult($result,$i,"points");


// promotions
$rec->data['id_promotions']=$db->FetchResult($result,$i,"id_promotions");
$rec->data['promotions_name']=$db->FetchResult($result,$i,"promotions_name");
$rec->data['promotions_discount']=$db->FetchResult($result,$i,"promotions_discount");
// end

//uwagi klienta
$rec->data['user_description']=$db->FetchResult($result,$i,"user_description");

// suma kontrolna obliczona dla pola confirm
$my_checksum=OrderChecksum::checksum($rec->data['order_id'],$rec->data['confirm'],$rec->data['amount']);

// suma kontrolna obliczona dla pola confirm_online
if (empty($rec->data['delivery_cost'])) $rec->data['delivery_cost']=0;
$amount_online=number_format($rec->data['amount']+$rec->data['delivery_cost'],2,'','.');
$my_checksum_online=OrderRegisterChecksum::checksum($rec->data['order_id'],$rec->data['confirm_online'],$amount_online);

if ((@$rec->data['amount_c']!=($rec->data['amount']+$rec->data['delivery_cost'])) && (@$rec->data['amount_c']>0)) {
    // kwota potwierdzenia sie nie zgadza
    $rec->data['fraud']=10;
}

if ($rec->data['checksum']!=$my_checksum) {
    // suma kontrolna sie nie zgadza
    $rec->data['fraud']=1;
}

if ($rec->data['checksum_online']!=$my_checksum_online) {
    // suma kontrolna potwierdzenia online sie nie zgadza
    $rec->data['fraud']=2;
}

// data potwierdzenia trsnsakcji
$rec->data['time_alert']=-1;$rec->data['time_alert_past']=0;
$rec->data['date_confirm']=$db->FetchResult($result,$i,"date_confirm");

// pokazuj przypomnienie tylko dla transakcji niedokonczonych pay_status!=002
if ((! empty($rec->data['date_confirm'])) && ($rec->data['date_confirm']!="0000-00-00") && ($rec->data['pay_status']!='002')) {
    
    $year1=date("Y");
    $month1=date("m");
    $day1=date("d");
    
    preg_match("/([0-9]+)-([0-9]+)-([0-9]+)/",$rec->data['date_confirm'],$date2);
    $year2=$date2[1];
    $month2=$date2[2];
    $day2=$date2[3];
    
    // czy $calc_date_confirm >= $rec->date_confirm ?
    // jesli tak to pokaz ostrzezenie, ze konczy sie termin rozliczenia transakcji
    $diff_days=Date_Calc::dateDiff($day1,$month1,$year1,$day2,$month2,$year2);
    
    if ($diff_days<=$config->order_alert_days) {
        $rec->data['time_alert']=$diff_days;
    }
    
    if (Date_Calc::isPastDate($day2,$month2,$year2)) {
        $rec->data['time_alert_past']=1;
        $rec->data['time_alert']=$diff_days;
    }
}
// end

// main_keys sprzedaz online; wartosc !=0 oznacza, ze w zamowieniu sa produkty przeznaczone do sprzedazy on-line
$rec->data['main_keys_status']=$db->FetchResult($result,$i,"main_keys_status");

// odczytaj warto¶c zamówienia wg tabeli order_products (warto¶c, która mo¿e byæ zmeiniana przez sprzedawcê)
$rec->data['total_amount']=$theme->price($db->FetchResult($result,$i,"total_amount"));

// odczytaj, kto ostatnio modyfikowal transakcje
$rec->data['id_admin_users']=$db->FetchResult($result,$i,"id_admin_users");
if (! empty($rec->data['id_admin_users'])) {
    $rec->data['admin_user']=$mdbd->select("login","admin_users","id=?",array($rec->data['id_admin_users']=>"int"));
} else $rec->data['admin_user']='';

// data ostatniej modyfikacji
$timestamp=$db->FetchResult($result,$i,"date_update");
require_once ("include/date.inc");
$my_date =& new MyDate;
$rec->data['date_update']=$my_date->timestamp2yyyy_mm_dd_time($db->FetchResult($result,$i,"date_update"));

// odczytaj ID danych klienta oraz dane klienta
$rec->data['id_users_data']=$db->FetchResult($result,$i,"id_users_data");
if (! empty($rec->data['id_users_data'])) {
    $rec->data['users']=$mdbd->select("crypt_firm,crypt_name,crypt_surname,crypt_street,crypt_street_n1,crypt_street_n2,crypt_postcode,crypt_city,crypt_country,crypt_email,crypt_nip,crypt_phone,crypt_cor_firm,crypt_cor_name,crypt_cor_surname,crypt_cor_street,crypt_cor_street_n1,crypt_cor_street_n2,crypt_cor_postcode,crypt_cor_city,crypt_cor_country,crypt_cor_email,crypt_cor_phone","users","id=?",array($rec->data['id_users_data']=>"int"),"LIMIT 1");
    // odkoduj dane
    $crypt =& new MyCrypt;$tmp=array(); $tmp_cor=array();
    foreach ($rec->data['users'] as $key=>$val) {
        if (! ereg("crypt_cor",$key)) {
            $keyn=ereg_replace("crypt_","",$key);
            $tmp[$keyn]=$crypt->endecrypt('',$val,'de');
        } else {
            $keyn=ereg_replace("crypt_cor_","",$key);
            if (! empty($val)) {
                $tmp_cor[$keyn]=$crypt->endecrypt('',$val,'de');
            }
        }
    }
    $rec->data['users']=$tmp;
    $rec->data['users_cor']=$tmp_cor;
} else {
    $rec->data['users']=array();
    $rec->Data['users_cor']=array();
}
if ($rec->data['points']) {
	$points_value=$mdbd->select('points','users_points_history','order_id=?',array($rec->data['order_id']=>"int"),"LIMIT 1");
	$rec->data['points_value']=$points_value;
}
?>
