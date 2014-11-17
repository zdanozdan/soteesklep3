<?php
/**
* Rozszezenie FormCheck; idywidualne funkcje sprawdzania danych z formularza instalacji
*
* @author  m@sote.pl
* @version $Id: my_form_check.inc.php,v 2.4 2005/03/24 10:02:29 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/

require_once("include/form_check.inc");
require_once ("./include/license.inc.php");

class MyFormCheck extends FormCheck {

    /**
    * Sprawd¼ pole serwera bazy danych
    *
    * @param  string $host nazwa hosta, na którym jest baza danych
    * @return bool true dane poprwane, false w p.w.
    */
    function dbhost($host) {
        $this->dbhost=$host;
        return $this->string($host);
    } // end dbhost()

    /**
    * Sprawd¼ pole dbname - nazwa bazy danych
    *
    * @param  string $name nazwa bazy
    * @return bool true dane poprwane, false w p.w.
    */
    function dbname($name) {
        $this->dbname=$name;
        return $this->string($name);
    } // end dbname()

    /**
    * Sprawd¼ nazwê u¿ytkownika bazy danych
    *
    * @param  string $host nazwa hosta, na którym jest baza danych
    * @return bool true dane poprwane, false w p.w.
    */
    function dbuser($user) {
        $this->dbuser=$user;
        return $this->string($user);
    } // end db_user()

    /**
    * Sprawd¼ has³o do bazy danych
    *
    * @param  string $password has³o dostêpu do bazy danych
    * @return bool true dane poprwane, false w p.w.
    */
    function dbpassword($password) {
        $this->dbpass=$password;
        return $this->db_test();
    } // end dbpassword()

    /**
    * Sprawd¼ pole PIN
    *
    * @param  string $pin PIN
    * @return bool true dane poprwane, false w p.w.
    */
    function pin($pin) {
        $this->pin=$pin;
        return $this->string($pin);
    } // end pin()

    /**
    * Sprawd¼ czy PIN zosta³ poprawnie powtórzony
    *
    * @param  string $pin2 powtórzony pin
    * @return bool true dane poprwane, false w p.w.
    */
    function pin2($pin2) {
        if ($this->pin==$pin2) {
            return true;
        }
        return false;
    } // end pin2()

    function license($license) {
        $lic = new License;
        return $lic->check($license);
    } // end license()

    /**
    * Sprawdz, czy login, haslo i server sa poprawne (sprawdzenie dostepu do bazy danych)
    *
    * @return bool true dane poprwane, false w p.w.
    */
    function db_test() {
        global $db;
        global $config;
        global $DOCUMENT_ROOT;

        $error=MetabaseSetupDatabaseObject(array(
        "Host"=>$this->dbhost,
        "Type"=>$config->dbtype,
        "User"=>$this->dbuser,
        "Password"=>$this->dbpass,
        "Persistent"=>false,
        "IncludePath"=>"$DOCUMENT_ROOT/../lib/Metabase"),$db);

        if (! empty($error)) {
            return false;
        }

        // ustaw baze nazwe bazy danych
        $db->SetDatabase($this->dbname);
        // stworz testowa tabele
        $result=$db->Query("CREATE TABLE soteesklep_install_test (name TEXT, id_shop INT default '0')");
        if ($result!=0) {
            return true;
        } else {
            $result2=$db->Query("SELECT name FROM soteesklep_install_test LIMIT 1");
            if ($result2!=0) {
                return true;
            } else {
                print ("Error: ".$db->error());
                return false;
            }
        }
    } // end db_test()

    /**
    * Sprawd¿ nazwê serwera FTP
    *
    * @param  string $host nazwa serwera FTP
    * @return bool true dane poprwane, false w p.w.
    */
    function ftp_host($host) {
        $this->ftp_host=$host;
        return $this->string($host);
    } // end ftp_host()

    function ftp_user($user) {
        $this->ftp_user=$user;
        return $this->string($user);
    } // end ftp_user()

    /**
    * Polacz sie z serwerem FTP i sprobuj sie zalogowac.
    *
    * @param  string $password has³o dostêpu do konta FTP
    * @return bool true - dane poprawne, logowanie testowe powiodlo sie, false w przeciwnym wypadku
    */
    function ftp_test($password) {
        $this->ftp_password=$password;
        $this->conn_id = @ftp_connect($this->ftp_host);
        $login_result = @ftp_login($this->conn_id,"$this->ftp_user","$this->ftp_password");
        if (! $this->conn_id)  return false;
        if (! $login_result)   return false;
        return true;
    } // end ftp_test()

} // end class MyFormCheck

?>
