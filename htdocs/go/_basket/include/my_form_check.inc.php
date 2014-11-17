<?php
/**
 * Rozszezenie FormCheck; idywidualne funkcji sprawdzania formualrza logowania, zmiany hasla, 
 * danych bilingowych rejestrowanego klienta
 *
 * @author  m@sote.pl
 * @version $Id: my_form_check.inc.php,v 2.1 2006/02/15 12:47:28 krzys Exp $
* @package    users
 */

require_once ("include/form_check.inc");
require_once ("include/metabase.inc");
require_once ("include/my_crypt.inc");

class MyFormCheck extends FormCheck {


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

    function register_fields()
    {
       $this->fun['firm']="null";
       $this->fun['name']="string";
       $this->fun['surname']="string";
       $this->fun['street']="string";
       $this->fun['street_n1']="string";
       $this->fun['street_n2']="null";
       $this->fun['postcode']="string";
       $this->fun['city']="string";
       $this->fun['phone']="string";
       $this->fun['email']="users_email";
       $this->fun['nip']="nip";
       $this->fun['news']="yes";
       $this->fun['description']="null";
       $this->fun['cor_addr']="null";
       $this->fun['country']="null";
    }

    function register_cor_fields()
    {
       $this->fun['firm']="null";
       $this->fun['name']="string";
       $this->fun['surname']="string";
       $this->fun['street']="string";
       $this->fun['street_n1']="string";
       $this->fun['street_n2']="null";
       $this->fun['postcode']="string";
       $this->fun['city']="string";
       $this->fun['phone']="null";
       $this->fun['email']="null";
       $this->fun['nip']="nip";
       $this->fun['news']="yes";
       $this->fun['description']="null";
       $this->fun['cor_addr']="null";
       $this->fun['country']="null";
    }
} // end class MyFormCheck

?>
