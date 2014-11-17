<?php
/**
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author  pmalinski@sote.pl
 * \@template_version Id: form_check_functions.inc.php,v 2.3 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: form_check_functions.inc.php,v 1.5 2006/01/20 10:14:06 lechu Exp $
 * @return  int $this->id
* @package    partners
 */
require_once("include/metabase.inc");

class FormCheckFunctions extends FormCheck {
    // lokalne definicja fukcji sptrawdzajacych poprawnosc pol formularza
    
    /**
     * Sprawdz czy pole jest typu procentowego 0-100% - zezwol na wpisywanie wartosci ponizej jednego procenta
     *
     * @param string $val wartosc pola
     * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
     */
    function percentage($val) {
        if (ereg("^[0-9.]+$",$val)) 
            if (($val>=0) && ($val<=100)) 
                return true;
        return false;
    }
    
    /**
     * Sprawdz czy pole jest wypelnione zgodnie z obowiazujacym formatem email
     *
     * @param string $val wartosc pola
     * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
     */
    function email($val) {
        
        if ((eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$",$val)) || (empty($val))) 
            return true;
        return false;
    }

    /**
     * Sprawdz czy pole zawiera osiem cyfr i czy taki identyfikator istnieje w bazie
     *
     * @param string $val wartosc pola
     * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
     */
    function partner_id($val) {
        global $database;

        if (eregi("^[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$",$val)) {
            $check=$database->sql_select("id","partners","partner_id=$val");
            if(! empty($check)) return false; 
            return true;
        }
        return false;
    }

    
    /**
     * Sprawdz login, czy czasem podany login juz nie istnieje
     * 
     * @param string $login login
     * @return bool true login nie istnieje, false - juz jest taki login 
     */
    function login($login) {
        global $lang;


        if (ereg("^[0-9a-z.-_@]+$",$login)) {
            // sprawdz czy czsami login taki juz nie istnieje
            // jesli tak to zmien komunikat o bledzie z $this->errors['login']
            if ($this->check_login($login)==false) {
                return true;
            }
            else {
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
        global $config, $id_partner;
        global $my_crypt;

        $crypt_login=$my_crypt->endecrypt("",$login,"");
        $query="SELECT id FROM users WHERE crypt_login=?";
        if(!empty($id_partner)) {
            $query="SELECT id FROM users WHERE crypt_login=? AND id_partner <> ?";
        }
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$crypt_login);
            if(!empty($id_partner)) {
                $db->QuerySetText($prepared_query,2,$id_partner);
            }
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
            return true;
        }
        return false;
    } // end password()
        
} // end class FormCheckFunctions
?>
