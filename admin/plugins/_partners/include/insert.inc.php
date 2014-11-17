<?php
/**
 * Dodaj nowy rekord do tabeli partners wykonaj komende SQL dodanie rekordu do bazy
 *
 * @author  pmalinski@sote.pl
 * \@global  string $table nazwa tabeli do ktorej dodajemy rekord
 * \@template_version Id: insert.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: insert.inc.php,v 1.4 2006/01/20 10:18:08 lechu Exp $
 * @return  int $this->id
* @package    partners
 */

if (@$this->secure_test!=true) die ("Bledne wywolanie");

global $db, $my_crypt, $config, $mdbd;
$prv_key = md5($config->salt);
// dodaj rekord
// config
$query = "INSERT INTO partners (name,partner_id,www,email,rake_off,crypt_password) VALUES (?,?,?,?,?,?)";
// end

$crypt_login = $my_crypt->endecrypt($prv_key, $this->data['login'], "");
$md5password = md5($this->data['password']);

$prepared_query = $db->PrepareQuery($query);
if ($prepared_query) {
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['name']);
    $db->QuerySetText($prepared_query,2,$this->data['partner_id']);
    $db->QuerySetText($prepared_query,3,$this->data['www']);
    $db->QuerySetText($prepared_query,4,$this->data['email']);  
    $db->QuerySetText($prepared_query,5,$this->data['rake_off']);
    $db->QuerySetText($prepared_query,6,$my_crypt->endecrypt($prv_key, $this->data['password'], ""));
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->partners_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());


// dodaj rekord w tabeli users

$id_partner = $this->id;
if(!empty($id_partner)) {
    // na wszelki wypadek czy¶cimy ewentualny wpis, który pasowa³by do ¶wie¿o dodanego partnera
    $mdbd->delete("users", "id_partner=?", array($id_partner => "int"));
    
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

?>