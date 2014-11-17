<?php
/**
* Przekoduj dane z wykorzystaniem nowego PIN'u.
* 1. Zmieñ w config/auto_config/user_config.inc.php dane
* var $db=array(
*     ...
*     'admin_dbuser'=>'%EC%92d%03',
*     'admin_dbpassword'=>'%EE%8Au%14h%3E',
*     ...
*     );
* var $ftp=array(
*     ...
*     'ftp_password'=>'%D5%B8T%23R%02B%DD%A3',
*     ...
*     );
*
* 2. Zmieñ pole passsword w tabeli admin_users.
*
*
* @author  m@sote.pl
* @version $Id: new_pin_gen.inc.php,v 2.4 2005/12/19 14:15:00 lukasz Exp $
* @package    admin_users
* @subpackage pin
*/

/**
* \@global string $__new_pin nowy PIN
* \@return
* \@global string $__pin nowy pin dostepny globalnie
*/

/**
* Start kodowanie hasla dostepu do ftp
*/
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

/**
* Klucze kodowania.
*/
require_once ("include/keys.inc.php"); global $__key,$__secure_key;

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkwonika.
*/
require_once("include/gen_user_config.inc.php");

// utworz nowy klucz kodowania
$new_secure_key=md5($config->salt.$__new_pin);

// odkoduj dane dostepu do bazy danych dla admina
$de_admin_dbuser=$my_crypt->endecrypt($__secure_key,$config->db['admin_dbuser'],"de");
$de_admin_dbpassword=$my_crypt->endecrypt($__secure_key,$config->db['admin_dbpassword'],"de");

// kodowanie hasla dostepu do bazy danych dla admina
$admin_dbuser=$my_crypt->endecrypt($new_secure_key,$de_admin_dbuser,"");
$admin_dbpassword=$my_crypt->endecrypt($new_secure_key,$de_admin_dbpassword,"");

// odkoduj haslo dostepu do konta FTP
$de_ftp_password=$my_crypt->endecrypt($__secure_key,$config->ftp['ftp_password'],"de");
$ftp_password=$my_crypt->endecrypt($new_secure_key,$de_ftp_password,"");

// przekoduj informacje w bazie danych
global $mdbd;
$passes=$mdbd->select('id,password','admin_users');
$output=array();
// rozszyfrowujemy i ponownie kodujemy w pamieci
foreach ($passes as $key=>$value) {
	unset($data);
	$dec_pass=$my_crypt->endecrypt($__secure_key,$value['password'],"de");
	$data['password']=$my_crypt->endecrypt($new_secure_key,$dec_pass,"");
	$data['id']=$value['id'];
	$output[]=$data;
}
// zapisujemy do bazy danych
foreach ($output as $key=>$value) {
	$pass=$value['password'];
	$id=$value['id'];
	$mdbd->update('admin_users','password=?','id=?',array($pass=>"text",$id=>"int"));
}
// end przekodowanie
// generuj sume kontrolna pin
$md5_pin=md5($__new_pin);

// zapamietaj/podmien przekodowane dane
$new_db=$config->db;
$new_db['admin_dbuser']=$admin_dbuser;
$new_db['admin_dbpassword']=$admin_dbpassword;
$new_ftp=$config->ftp;
$new_ftp['ftp_password']=$ftp_password;


// zapisz plik konfiguracyjny z sumami kontrolnymi
$gen_config->gen(array("db"=>$new_db,"ftp"=>$new_ftp,"md5_pin"=>$md5_pin));

// przekodouj klucz prywatny RSA sklepu

global $cardpay_config;
include_once("config/auto_config/cardpay_config.inc.php");
require_once ("include/crypt_db.inc");
$crypt_db  = new Crypt_DB;
global $__pin;
include_once ("include/pin.inc.php");
$crypt_db->key=md5($config->salt.$__pin);
// rozszyfrowujemy klucz pinem
$private_key=$crypt_db->cardkey();
// przypisujemy
// kodujemy nowym pinem
$private_key=$my_crypt->endecrypt($new_secure_key,$private_key,"");
// zapisujemy configa
global $ftp;
$ftp->connect();
$gen_config = new GenConfig;
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="cardpay_config.inc.php";         // nazwa generowanego pliku 
$gen_config->classname="CardPayConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="cardpay_config";                // 1) nazwa tworzonego obiektu klasy w/w 
$gen_config->vars=array("pub_key","priv_key","active");
$gen_config->config=&$cardpay_config;                      // przekaz aktualne wartosci obiektu 1)
$gen_config->gen(array("priv_key"=>$private_key));
$ftp->close();


$__pin=$__new_pin;
$sess->register("__pin",$__pin);
?>
