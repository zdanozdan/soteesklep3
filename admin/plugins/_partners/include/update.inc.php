<?php
/**
 * Aktualizuj dane w tabeli partners
 * 
 * @author  pmalinski@sote.pl
 * \@template_version Id: update.inc.php,v 2.2 2003/06/14 21:59:38 maroslaw Exp
 * @version $Id: update.inc.php,v 1.3 2006/01/20 10:21:11 lechu Exp $
* @package    partners
 */

global $db, $my_crypt, $config, $mdbd;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

$prv_key = md5($config->salt);
$crypt_password = $my_crypt->endecrypt($prv_key, $this->data['password'], "");


// config
$query="UPDATE partners SET name=?, partner_id=?, www=?, email=?, rake_off=?, crypt_password=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,$this->data['partner_id']);  
    $db->QuerySetText($prepared_query,3,$this->data['www']);
    $db->QuerySetText($prepared_query,4,$this->data['email']);  
    $db->QuerySetText($prepared_query,5,$this->data['rake_off']);
    $db->QuerySetText($prepared_query,6,$crypt_password);
    $db->QuerySetText($prepared_query,7,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->partners_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

$id_partner = $this->id;

if(!empty($id_partner)) {
    
    $crypt_login = $my_crypt->endecrypt($prv_key, $this->data['login'], "");
    $md5password = md5($this->data['password']);
    
    $mdbd->select("id", "users", "id_partner=?", array($id_partner => "int"));
    if($mdbd->num_rows > 0) { // odpowiednik w tabeli users istnieje
        // aktualizujemy wpis
        $query = "UPDATE users SET crypt_login=?, crypt_password=? WHERE id_partner=?";
        $prepared_query = $db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$crypt_login);
            $db->QuerySetText($prepared_query,2,$md5password);
            $db->QuerySetText($prepared_query,3,$id_partner);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result == 0) {
                die ($db->Error());
            }
        } else die ($db->Error());
    }
    else { // odpowiednik w tabeli users nie istnieje
        // dodajemy wpis
        $query = "INSERT INTO users (crypt_login,crypt_password,id_partner) VALUES (?,?,?)";
        $prepared_query = $db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$crypt_login);
            $db->QuerySetText($prepared_query,2,$md5password);
            $db->QuerySetText($prepared_query,3,$id_partner);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result == 0) {
                die ($db->Error());
            }
            
        } else die ($db->Error());    
    }
}
?>
