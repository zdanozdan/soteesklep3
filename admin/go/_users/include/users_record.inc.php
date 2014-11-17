<?php
/**
* Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
* Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
*
* @author  m@sote.pl
* @version $Id: users_record.inc.php,v 2.4 2004/12/20 17:59:17 maroslaw Exp $
* @package    users
*/

/**
* Dodaj obs³uê kodowania.
*/
require_once ("include/my_crypt.inc");
$my_crypt =& new MyCrypt;
$my_crypt->gen_keys();

/**
* Klasa z funkcj± prezentacji rekordu na li¶cie.
* @package users
* @subpackage admin
*/
class UsersRecordRow {
    
    /**
    * Odczytanie danych klienta oraz wywo³anie wy¶wietlenia wiersza na li¶cie.
    *
    * @param mixed $result wynik zapytania z bazy danych
    * @param int   $i      numer wiersza w zapytaniu SQL
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;
        global $rec;
        global $my_crypt;
        
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        
        $crypt_login=$db->FetchResult($result,$i,"crypt_login");
        $crypt_name=$db->FetchResult($result,$i,"crypt_name");
        $crypt_surname=$db->FetchResult($result,$i,"crypt_surname");
        $crypt_email=$db->FetchResult($result,$i,"crypt_email");
        
        $decrypt_login=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_login,"de");
        $decrypt_name=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_name,"de");
        $decrypt_surname=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_surname,"de");
        $decrypt_email=$my_crypt->endecrypt($my_crypt->pub_key,$crypt_email,"de");
        
        $rec->data['login']=&$decrypt_login;
        $rec->data['name']=&$decrypt_name;
        $rec->data['surname']=&$decrypt_surname;
        $rec->data['email']=&$decrypt_email;
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        $rec->data['sales']=$db->FetchResult($result,$i,"sales");
        
        
        /**
        * Wy¶wietl wiersz z danymi u¿ytkwonika imiê, nazwisko, email.
        */
        include ("./html/users_record_row.html.php");
        
        return;
    } // end record()
    
} // end class UsersRecordRow
