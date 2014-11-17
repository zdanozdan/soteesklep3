<?php
/**
 * Rozszezenie FormCheck; idywidualne funkcji sprawdzania formualrza logowania, zmiany hasla, 
 * danych bilingowych rejestrowanego klienta
 *
 * @author  m@sote.pl
 * @version $Id: my_form_check.inc.php,v 2.9 2006/01/31 14:09:02 krzys Exp $
* @package    users
 */

require_once ("include/form_check.inc");
require_once ("include/metabase.inc");
require_once ("include/my_crypt.inc");

class MyFormCheck extends FormCheck {

    /**
     * Sprawdz stare haslo klienta
     *
     * @param  string $old_password   stare haslo
     * \@global int    $global_id_user id klienta z tabeli users
     * @table  users
     * 
     * @return bool   true - haslo sie zgadza, false - bledne haslo
     */
    function old_password($old_password) {
        global $db;
        global $_SESSION;

        if (! empty($_SESSION['global_id_user'])) {
            $global_id_user=$_SESSION['global_id_user'];
        } else return false;
        
        $query="SELECT crypt_password FROM users WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$global_id_user);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $crypt_password=$db->FetchResult($result,0,"crypt_password");
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());

        if ($crypt_password==md5($old_password)) return true;
        
        return false;
    } // end old_password()
    
    
    /**
     * Sprawdz login, czy czasem podany login juz nie istnieje
     * 
     * @param string $login login
     * @return bool true login nie istnieje, false - juz jest taki login 
     */
    function login($login) {
        global $lang;
        global $_SESSION;

        // sprawdz, czy przed chwila nie dodano uzytwkonika
        // mozliwe, ze wywolano reload, w takim przypadku nie spraedzaj czy login taki juz istnieje
        if (! empty($_SESSION['new_login'])) {
            if ($_SESSION['new_login']==$login) return true;
        }

        if (ereg("^[0-9a-z.-_@]+$",$login)) {
            // sprawdz czy czsami login taki juz nie istnieje
            // jesli tak to zmien komunikat o bledzie z $this->errors['login']
            if ($this->check_login($login)==false) {
                return true;
            } else {
                $this->errors['login']=$lang->users_login_error;
                return false;
            }
        }

        return false;
    }
    
    /**
     * Sprawdz czy podany login jest juz w bazie
     *
     * @param string $login
     * @return bool true - adresu nie ma w bazie, false - adres jest w bazie
     */
    function check_login($login) {
        global $db;
        global $config;
        global $my_crypt;

        $crypt_login=$my_crypt->endecrypt("",$login,"");
        $query="SELECT id FROM users WHERE crypt_login=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$crypt_login);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows==0) return false;
                if ($num_rows>0) return true;
            } else die ($db->Error());
        } else die ($db->Error());        
    } // end login()

    /**
     * Sprawdz czy wprowadzono odpowiednio zlozone haslo
     * 
     * @param  string $password haslo
     * @return bool   true - ok, false wpw
     */
    function password($password) {
        if (strlen($password)>=6) {
            $this->password=$password;
            return true;
        }
        $this->password="";
        return false;
    } // end password()

    /**
     * Sprawdz czy powtorzone haslo jest takie samo
     *
     * @param  string $password2 powtorzone haslo
     * @return bool   true - hasla zgadzaja sie, false wpw 
     */
    function confirm_password($password2) {
        if ($password2==$this->password) 
            return true;
        return false;
    } // end confirm_password()

    /**
     * Sprawdz czy istnieje dany email w bazie w tabeli users
     * 
     * @param string $email
     * @return bool true - nie istneije, false - istnieje
     */
    function users_email($email) {
        global $db;
        global $mdbd;
        global $my_crypt;  
        global $_SESSION;
        
        if (empty($email)) return false;
        
        $crypt_email=$my_crypt->endecrypt('',$email);
        $db_id=$mdbd->select("id","users","crypt_email=? AND order_data!=1",array($crypt_email=>"text"),"LIMIT 1");
        
        if (($db_id>0) && ($db_id!=$_SESSION['global_id_user'])) {
            return false;
        }           
         
        if (!$this->email($email)) return $this->email($email);

        $crypt_email=$my_crypt->endecrypt("",$email,"");
        if (strlen($crypt_email)>255) return 1; // kod emaila nie moze byc dluzszy niz pole w bazie
        return true;        
    } // end users_email()
    
} // end class MyFormCheck

?>
