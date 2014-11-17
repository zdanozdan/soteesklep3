<?php
/**
 * Aktualizuj dane transakcji
 *
 * @global string $global_update_status informacja o wyniku aktualizacji (tekst)
 */
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;
global $config;
global $db;
//$global_prv_key=md5($form['crypt_password'].$config->salt);
$global_prv_key='';
$data=array();
// dane bilingowe
$data['login']=$my_crypt->endecrypt("",$form['crypt_login'],"");
$data['password']=$password=md5($form['crypt_password']);
$data['name']=$my_crypt->endecrypt("",$form['crypt_name'],"");
$data['surname']=$my_crypt->endecrypt("",$form['crypt_surname'],"");
$data['email']=$my_crypt->endecrypt("",$form['crypt_email'],"");
$data['firm']=$my_crypt->endecrypt($global_prv_key,$form['crypt_firm'],"");
$data['street']=$my_crypt->endecrypt($global_prv_key,$form['crypt_street'],"");
$data['street_n1']=$my_crypt->endecrypt($global_prv_key,$form['crypt_street_n1'],"");
$data['street_n2']=$my_crypt->endecrypt($global_prv_key,$form['crypt_street_n2'],"");
$data['postcode']=$my_crypt->endecrypt($global_prv_key,$form['crypt_postcode'],"");
$data['city']=$my_crypt->endecrypt($global_prv_key,$form['crypt_city'],"");
$data['country']=$my_crypt->endecrypt($global_prv_key,$form['crypt_country'],"");
$data['phone']=$my_crypt->endecrypt($global_prv_key,$form['crypt_phone'],"");
$data['nip']=$my_crypt->endecrypt($global_prv_key,$form['crypt_nip'],"");

// dane korepsondencyjne
$data['cor_name']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_name'],"");
$data['cor_surname']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_surname'],"");
$data['cor_email']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_email'],"");
$data['cor_firm']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_firm'],"");
$data['cor_street']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_street'],"");
$data['cor_street_n1']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_street_n1'],"");
$data['cor_street_n2']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_street_n2'],"");
$data['cor_postcode']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_postcode'],"");
$data['cor_city']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_city'],"");
$data['cor_country']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_country'],"");
$data['ext_info']=$my_crypt->endecrypt($global_prv_key,$form['crypt_ext_info'],"");
$data['id']=$form['id'];
$data['date_add']=$form['date_add'];
$data['cor_phone']=$my_crypt->endecrypt($global_prv_key,$form['crypt_cor_phone'],"");
$data['record_version']=$form['record_version'];

print "<pre>";
print_r($form);
print "</pre>";
if(!empty($form['crypt_login'])) {
$count=$database->sql_select("count(*)","users","crypt_email=".$data['email']);
if($count == 0) {
	$query="INSERT INTO users (crypt_firm,crypt_name,crypt_surname,
                         crypt_street,crypt_street_n1, crypt_street_n2,
                         crypt_country, crypt_postcode, crypt_city,
                         crypt_phone, crypt_email, crypt_nip,
                         crypt_cor_firm, crypt_cor_name, crypt_cor_surname,
                         crypt_cor_street, crypt_cor_street_n1, crypt_cor_street_n2,
                         crypt_cor_country, crypt_cor_postcode, crypt_cor_city,
                         crypt_cor_email,crypt_login,crypt_password,date_add,
						 crypt_ext_info,crypt_cor_phone,record_version,remark_admin)
                     VALUES (?,?,?,
					 		 ?,?,?,
							 ?,?,?,
							 ?,?,?,
							 ?,?,?,
							 ?,?,?,
							 ?,?,?,
							 ?,?,?,?,
							 ?,?,?,?)";

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
		$db->QuerySetText($prepared_query,23,$data['login']);
		$db->QuerySetText($prepared_query,24,$data['password']);
		$db->QuerySetText($prepared_query,25,$data['date_add']);
		$db->QuerySetText($prepared_query,26,$data['ext_info']);
		$db->QuerySetText($prepared_query,27,$data['cor_phone']);
		$db->QuerySetText($prepared_query,28,$data['record_version']);
		$db->QuerySetText($prepared_query,29,$data['remark_admin']);


    	$result=$db->ExecuteQuery($prepared_query);
    		if ($result!=0) {
        	// aktualizacja danych klienta zakonczyla sie pomyslnie
        	//$global_update_status=$lang->edit_update_ok;
    	} else die ($db->Error());
	} else die ($db->Error());
} else {
	$this->record_add--;
	print "Adres juz jest w bazie<br>";
} 
} else {
	$this->record_add--;
	print "Dane sa niepoprawne<br>";
}

$query="SELECT max(id) FROM users";
    $result1=$db->Query($query);
    if ($result1!=0) {
        $num_rows=$db->NumberOfRows($result1);
        if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $max=$config->$var;
                $global_id_user=$db->FetchResult($result1,0,$max);
    } else die ($db->Error());
} else die ($db->Error());

// zapisz klucz uzytkwonika w users_keys
/*$query="INSERT INTO users_keys (id_users,user_key) VALUES (?,?)";
	$prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
    	$db->QuerySetInteger($prepared_query,1,$global_id_user);
        $db->QuerySetText($prepared_query,2,$global_prv_key);
        $result1=$db->ExecuteQuery($prepared_query);
        if ($result1!=0) {
        	// Klucz zostal poprawnie dodany do bazy
        } else die ($db->Error());
   } else die ($db->Error());*/
  // koniec zpisania klucza usera w bazie
?>
