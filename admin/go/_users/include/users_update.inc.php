<?php
/**
 * Aktualizuj dane transakcji
 *
 * \@global string $global_update_status informacja o wyniku aktualizacji (tekst)
 * \@global string $global_prv_key klucz prywatny kodowania danych
* @version    $Id: users_update.inc.php,v 2.13 2006/01/30 14:57:00 krzys Exp $
* @package    users
 */

if (@$global_secure_test!=true) {
    die ("Bledne wywolanie");
}

// odczytaj dane z formularza, zakuduj dane odpowiednim kluczem
if (! empty($_POST['form'])) {
    $form=$_POST['form'];
} else die ("Bledne wywolanie");

$data=array();

// dane bilingowe
$data['name']=$my_crypt->endecrypt("",$form['name'],"");
$data['surname']=$my_crypt->endecrypt("",$form['surname'],"");
$data['email']=$my_crypt->endecrypt("",$form['email'],"");
$data['firm']=$my_crypt->endecrypt($global_prv_key,$form['firm'],"");
$data['street']=$my_crypt->endecrypt($global_prv_key,$form['street'],"");
$data['street_n1']=$my_crypt->endecrypt($global_prv_key,$form['street_n1'],"");
$data['street_n2']=$my_crypt->endecrypt($global_prv_key,$form['street_n2'],"");
$data['postcode']=$my_crypt->endecrypt($global_prv_key,$form['postcode'],"");
$data['city']=$my_crypt->endecrypt($global_prv_key,$form['city'],"");
$data['country']=$my_crypt->endecrypt($global_prv_key,$form['country'],"");
$data['phone']=$my_crypt->endecrypt($global_prv_key,$form['phone'],"");
$data['nip']=$my_crypt->endecrypt($global_prv_key,$form['nip'],"");

// dane korepsondencyjne
$data['cor_name']=$my_crypt->endecrypt($global_prv_key,$form['cor_name'],"");
$data['cor_surname']=$my_crypt->endecrypt($global_prv_key,$form['cor_surname'],"");
$data['cor_email']=$my_crypt->endecrypt($global_prv_key,$form['cor_email'],"");
$data['cor_firm']=$my_crypt->endecrypt($global_prv_key,$form['cor_firm'],"");
$data['cor_street']=$my_crypt->endecrypt($global_prv_key,$form['cor_street'],"");
$data['cor_street_n1']=$my_crypt->endecrypt($global_prv_key,$form['cor_street_n1'],"");
$data['cor_street_n2']=$my_crypt->endecrypt($global_prv_key,$form['cor_street_n2'],"");
$data['cor_postcode']=$my_crypt->endecrypt($global_prv_key,$form['cor_postcode'],"");
$data['cor_city']=$my_crypt->endecrypt($global_prv_key,$form['cor_city'],"");
$data['cor_country']=$my_crypt->endecrypt($global_prv_key,$form['cor_country'],"");
$data['cor_phone']=$my_crypt->endecrypt($global_prv_key,$form['cor_phone'],"");
$data['remark_admin']=$form['remark_admin'];

// blokada uzytkownika
if (!empty($form['lock_user'])) {
    $data['lock_user']=1;
} else $data['lock_user']=0;

// grupa rabatowa
$data['id_discounts_groups']=$form['id_discounts_groups'];

// status uzytkownika hurtowego
$data['hurt']=$form['hurt'];

//handlowiec przypisany do klienta
$data['sales']=my(@$form['sales']);

// limit kredytowy - info
$data['limits']=my(@$form['limits']);


$query="UPDATE users SET crypt_firm=?, crypt_name=?, crypt_surname=?,
                         crypt_street=?, crypt_street_n1=?, crypt_street_n2=?,
                         crypt_country=?, crypt_postcode=?, crypt_city=?,
                         crypt_phone=?, crypt_email=?, crypt_nip=?,
                         crypt_cor_firm=?, crypt_cor_name=?, crypt_cor_surname=?,
                         crypt_cor_street=?, crypt_cor_street_n1=?, crypt_cor_street_n2=?,
                         crypt_cor_country=?, crypt_cor_postcode=?, crypt_cor_city=?,
                         crypt_cor_email=?, hurt=?, limits=?,
                         id_discounts_groups=?, lock_user=?,
                         crypt_cor_phone=?, remark_admin=?
                     WHERE id=? ";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$data['firm']);
    $db->QuerySetText($prepared_query,2,$data['name']);
    $db->QuerySetText($prepared_query,3,$data['surname']);
    $db->QuerySetText($prepared_query,4,$data['street']);
    $db->QuerySetText($prepared_query,5,$data['street_n1']);
    $db->QuerySetText($prepared_query,6,$data['street_n2']);
    $db->QuerySetText($prepared_query,7,$data['country']);
    $db->QuerySetText($prepared_query,8,$data['postcode']);
    $db->QuerySetText($prepared_query,9,$data['city']);
    $db->QuerySetText($prepared_query,10,$data['phone']);
    $db->QuerySetText($prepared_query,11,$data['email']);
    $db->QuerySetText($prepared_query,12,$data['nip']);
    $db->QuerySetText($prepared_query,13,$data['cor_firm']);
    $db->QuerySetText($prepared_query,14,$data['cor_name']);
    $db->QuerySetText($prepared_query,15,$data['cor_surname']);
    $db->QuerySetText($prepared_query,16,$data['cor_street']);
    $db->QuerySetText($prepared_query,17,$data['cor_street_n1']);
    $db->QuerySetText($prepared_query,18,$data['cor_street_n2']);
    $db->QuerySetText($prepared_query,19,$data['cor_country']);
    $db->QuerySetText($prepared_query,20,$data['cor_postcode']);
    $db->QuerySetText($prepared_query,21,$data['cor_city']);
    $db->QuerySetText($prepared_query,22,$data['cor_email']);
    $db->QuerySetText($prepared_query,23,$data['hurt']);    
    $db->QuerySetText($prepared_query,24,$data['limits']);
    $db->QuerySetText($prepared_query,25,$data['id_discounts_groups']);
    $db->QuerySetText($prepared_query,26,$data['lock_user']);
    $db->QuerySetText($prepared_query,27,$data['cor_phone']);
    $db->QuerySetText($prepared_query,28,$data['remark_admin']);
    $db->QuerySetInteger($prepared_query,29,$id);
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // aktualizacja danych klienta zakonczyla sie pomyslnie
        $global_update_status=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());



?>
