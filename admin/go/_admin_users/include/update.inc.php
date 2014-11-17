<?php
/**
* Aktualizuj dane w tabeli admin_users
*
* @author m@sote.pl
* @version $Id: update.inc.php,v 2.2 2004/12/20 17:57:53 maroslaw Exp $
* @package    admin_users
*/

global $db;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

/**
* Kluze kodowania.
*/
include_once ("include/keys.inc.php"); global $__key,$__secure_key;

/**
* Obs³uga kodowania.
*/
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

// config
$query="UPDATE admin_users SET login=?, password=?, id_admin_users_type=?, active=? WHERE id=?";
// end

// jesli podano nowe haslo to zapisz je w polu haslo
$this->data['password']=$this->data['new_password'];

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {

    // zakoduj haslo
    $password=$my_crypt->endecrypt($__secure_key,$this->data['password'],"");

    // config
    $db->QuerySetText($prepared_query,1,$this->data['login']);
    $db->QuerySetText($prepared_query,2,$password);
    $db->QuerySetText($prepared_query,3,$this->data['id_admin_users_type']);
    $db->QuerySetText($prepared_query,4,@$this->data['active']);
    $db->QuerySetInteger($prepared_query,5,$this->id);
    // end

    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->admin_users_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

// zapisz loginy i hasla w pliku hasel zdefiniowanym w .htaccess
// generuj sumy kotrolne dla logujacych sie uzytkownikow
include_once ("./include/save_params.inc.php");

/*
Dostosowuja ten skrypt do odpowiedniego zadania, nalezy edytowac obszarku okreslone jako
// config
... tu edytujemy
// end

*/
?>
