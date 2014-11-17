<?php
/**
 * Obsluga dekodowania danych dostep do bazy danych
 *
 * @author  m@sote.pl
 * @version $Id: crypt_db.inc,v 2.3 2005/10/26 12:40:11 lukasz Exp $
* @package    include
 */

// start kodowanie hasla dostepu do ftp
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

class Crypt_DB {
    /**
     * @return string login uzytkwonika anonimowego
     */
    function nobody_user() {
        global $config;
        global $my_crypt;
        return $my_crypt->endecrypt($this->key,$config->db['nobody_dbuser'],"de");
    } // end nobody_user()

    /**
     * @return string haslo uzytkownika anonimowego
     */ 
    function nobody_password() {
        global $config;
        global $my_crypt;
        return $my_crypt->endecrypt($this->key,$config->db['nobody_dbpassword'],"de");
    } // end nobody_password()

    /**
     * @return string login admina sklepu
     */
    function admin_user() {
        global $config;
        global $my_crypt;
        return $my_crypt->endecrypt($this->secure_key,$config->db['admin_dbuser'],"de");
    } // end admin_user

    /**
     * @return string haslo admina sklepu
     */
    function admin_password() {
        global $config;
        global $my_crypt;
        return $my_crypt->endecrypt($this->secure_key,$config->db['admin_dbpassword'],"de");
    } // end admin_password()

    /**
     * @return string host bazy danych
     */
    function host() {
        global $config;
        global $my_crypt;
        return $my_crypt->endecrypt($this->key,$config->db['dbhost'],"de");
    } // end host()

    /**
     * @return string nazwa bazy danych
     */
    function dbname() {
        global $config;
        global $my_crypt;
        return $my_crypt->endecrypt($this->key,$config->db['dbname'],"de");
    } // end dbname()

    /**
     * @return string rozszyfrowany klucz prywatny
     */
    function cardkey() {
        global $config;
        global $cardpay_config;
        global $my_crypt;
        return $my_crypt->endecrypt($this->key,$cardpay_config->priv_key,"de");
    } // end dbname()

} // end class Crypt_DB

?>
