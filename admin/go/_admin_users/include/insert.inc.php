<?php
/**
* Dodaj nowy rekord do tabeli admin_users wykonaj komende SQL dodanie rekordu do bazy
*
* @author m@sote.pl
* @version $Id: insert.inc.php,v 2.3 2004/12/20 17:57:52 maroslaw Exp $
* @return int $this->id
* @package    admin_users
*/

/**
* \@global string $table nazwa tabeli do ktorej dodajemy rekord
*/
if (@$this->secure_test!=true) die ("Bledne wywolanie");

/**
* Obsluga kodowania + klucze
*/
require_once ("include/keys.inc.php"); global $__key,$__secure_key;
/**
* Kodowanie.
*/
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

global $db;

// dodaj rekord
// config
$query="INSERT INTO admin_users (login,password,id_admin_users_type,active) VALUES (?,?,?,?)";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // jesli podano nowe haslo to zapisz je w polu haslo
    if ((empty($this->data['password'])) && (! empty($this->data['new_password']))) {
        $this->data['password']=$this->data['new_password'];
    }
    
    // zakoduj haslo
    $password=$my_crypt->endecrypt($__secure_key,$this->data['password'],"");
    
    // config
    $db->QuerySetText($prepared_query,1,$this->data['login']);
    $db->QuerySetText($prepared_query,2,$password);
    $db->QuerySetInteger($prepared_query,3,$this->data['id_admin_users_type']);
    $db->QuerySetText($prepared_query,4,@$this->data['active']);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM $table";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->admin_users_record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $this->id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());
    } else die ($db->Error());
} else die ($db->Error());

// zapisz loginy i hasla w pliku hasel zdefiniowanym w .htaccess
// generuj sumy kotrolne dla logujacych sie uzytkownikow
include_once ("./include/save_params.inc.php");
?>
