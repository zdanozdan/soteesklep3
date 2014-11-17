<?php
/**
* Generowanie pliku hase³ do  .htaccess na podstawie danych z tabeli admin_users.
* Generowanie sum kontrolnych dla loguj±cych sie u¿tkownikow.
*
* @author  m@sote.pl
* @version $Id: save_params.inc.php,v 2.3 2004/12/20 17:57:53 maroslaw Exp $
* @package    admin_users
*/

global $DOCUMENT_ROOT;
global $ftp;
global $gen_config;

/**
* Utworz plik z loginem i has³em dostêpu do Auth Basic .htaccess
*/
require_once("include/htaccess.inc.php");
/**
* Obs³uga kodowania.
*/
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;
/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkwonika.
*/
require_once("include/gen_user_config.inc.php");

// start odczytaj liste uzytkownikow i odkoduj hasla, wynik zapamietaj w tablicy $htaccess_users=array("login"=>"haslo",...)
$query="SELECT login,password FROM admin_users WHERE active=1 ORDER BY id";
$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    $i=0;
    $htaccess_users=array();
    $auth_sign_password=array();
    while ($i<$num_rows) {
        $login=$db->FetchResult($result,$i,"login");
        $crypt_password=$db->FetchResult($result,$i,"password");
        $password=$my_crypt->endecrypt($__secure_key,$crypt_password,"de");
        $htaccess_users[$login]=$password;
        $auth_sign_users[md5($login)]=$login;
        $i++;
    } // end while
} else die ($db->Error());
// end


// zapisz pliki z haslami do htaccess
$ftp->connect();
$htaccess = new htaccess;
$htaccess->gen_passwd_file($htaccess_users,"passwd.www");
$tmp_file="$DOCUMENT_ROOT/setup/tmp/passwd.www";
$ftp->put($tmp_file,$config->ftp_dir."/config/etc","passwd.www");
unlink ($tmp_file);


// zapisz plik konfiguracyjny z sumami kontrolnymi
$gen_config->gen(array("auth_sign"=>$auth_sign_users));

$ftp->close();
?>
