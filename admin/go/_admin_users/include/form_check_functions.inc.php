<?php
/**
* Sprawd¼ poprawnosc formularza, dodatkowe funkcje.
*
* @author m@sote.pl
* @version $Id: form_check_functions.inc.php,v 2.7 2005/07/12 13:26:03 lukasz Exp $
* @package    admin_users
*/

/**
* Obsluga kodowania + klucze.
*/
require_once ("include/keys.inc.php"); global $__key,$__secure_key;
/**
* Klasa kodowania danych.
*/
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

/**
* Klasa z dodatkowymi funkcjami validacji pól formularza.
* @package admin_users
* @ignore
*/
class FormCheckFunctions extends FormCheck {
    
    /**
    * Sprawd¼, zapamiêtaj numer ID.
    *
    * @param int $id ID
    * @return true
    */
    function id($id) {
        $this->id=$id;
        return true;
    } // end id()
    
    /**
    * Sprawd¼, zapamiêtaj id grupy u¿ytkowników.
    *
    * @param int $type ID grupy
    * @return true 
    */
    function id_admin_users_type($type) {
        $this->type=$type;
        if ($type==1) $this->superadmin=1;
        else $this->superadmin=0;
        return true;
    } // end id_admin_users_type()
    
    /**
    * Sprawd¼ stare/obecne has³o.
    * Opcja ta pojawia siê tylko g³ównemu adminowi (super admin), wiêc 
    * weryfikacja zosta³a pominiêta.
    *
    * @param string $password stare haslo
    * @return true
    */
    function password($password) {
        return true;
        /*
        global $db;
        global $my_crypt;
        global $__secure_key;
        
        if  ($this->superadmin!=1) return true;
        
        // sprawdz obecne haslo uzytkownika
        $query="SELECT password FROM admin_users WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$this->id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows==1) {
        $crypt_password=$db->FetchResult($result,0,"password");
        // odkoduj haslo dla celow porownania
        $decrypt_password=$my_crypt->endecrypt($__secure_key,$crypt_password,"de");
        if ($decrypt_password==$password) {
        return true;
        } else return false;
        } else die ($error->error("admin_users_not_found"));
        } else die ($db->Error());
        } else die ($db->Error());
        
        return false;
        */
    } // end password()
    
    /**
    * Sprawd¼, czy zosta³o wprowadzone nowe has³o.
    *
    * @param string $password nowe has³o
    * @return bool
    */
    function new_password($password) {
        $this->new_password=$password;
        return $this->string($password);
    } // end new_password()
    
    /**
    * Sprawd¼, czy potworzone nowe haslo jest poprawne.
    *
    * @param string $password2 nowe has³o - powtórzone
    * @return bool
    */
    function new_password2($password2) {
        if ($this->new_password==$password2) return true;
        return false;
    } // end new_password2()
        
    /**
     * Sprawdzamy czy istnieje ju¿ taki login
     * Wywo³ywane tylko podczas dodawania nowego admina
     *
     * @author £ukasz
     * @param string $login
     * @return bool
     */
    function login($login) {
    	global $db;
    	// robimy update czy dodajemy nowego ?
    	if (empty($this->id)) {
    		$query = "SELECT id FROM admin_users WHERE login='$login'";
    	} else {
    		$query = "SELECT id FROM admin_users WHERE login='$login' AND id!='$this->id'";
    	}
    	$preparedquery = $db->PrepareQuery($query);
    	$result=$db->ExecuteQuery($preparedquery);
    	$num_rows=$db->NumberOfRows($result);
		if ($num_rows!=0) {
			// je¿eli znalazlem jakies wiersze w bazie - to znaczy ze mam juz usera o takim loginie i innym id
    		$__id=$db->FetchResult($result,0,"id");
	    	if ($__id!=$this->id) {
				return false;
			}
    	}
    	return true;
    } // end login()
} // end class FormChceckFunctions
?>
