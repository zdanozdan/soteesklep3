<?php

if (empty($form)) {
	die ("Forbidden: Unknown form");
}

require_once ("config/auto_config/cardpay_config.inc.php");
require_once ("config/auto_config/user_config.inc.php");
// generujemy klucze
require_once("PEAR/Crypt/RSA.php");
$key_pair = new Crypt_RSA_KeyPair(128);
$public_key = $key_pair->getPublicKey();
$public_key = $public_key->toString();
$private_key = $key_pair->getPrivateKey();
$private_key = $private_key->toString();

// szyfrujemy klucze i zapisujemy w configu
$__pin=$form['pin'];
$md5_pin=md5($__pin);
$pin=$__pin;
$salt=$config->salt;
$__salt=&$salt;

// kod którym zakodowany jest klucz prywatny sklepu
$key=$salt;
$secure_key=md5($salt.$pin);

// start kodowanie hasla dostepu do ftp
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;
$private_key = $my_crypt->endecrypt($secure_key,$private_key,"");

// zapisujemy konfiguracje
require_once ("include/gen_config.inc.php");
require_once("include/gen_user_config.inc.php");
$config->ftp_dir=$ftp_dir;$config->ftp['ftp_dir']=$ftp_dir;
$gen_config->ftp_user=$form['ftp_user'];
$gen_config->ftp_password=$form['ftp_password'];
$gen_config->ftp_host=$form['ftp_host'];
$gen_config->auth_from_db="no";
$gen_config->config_dir="/config/auto_config/";            // katalog generowanego pliku
$gen_config->config_file="cardpay_config.inc.php";         // nazwa generowanego pliku
$gen_config->classname="CardPayConfig";                    // nazwa klasy generowanego pliku
$gen_config->class_object="cardpay_config";                // 1) nazwa tworzonego obiektu klasy w/w
$gen_config->vars=array("pub_key","priv_key","active");

$gen_config->gen(array("active"=>"0",
"pub_key"=>$public_key,
"priv_key"=>$private_key,
)
);

?>