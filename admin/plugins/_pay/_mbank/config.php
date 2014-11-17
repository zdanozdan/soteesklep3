<?php
/**
 * Konfiguracja danych mBank (platnosc mTRANSFER), aktywacja/ustawienia uslugi
 *
 * @author  p@sote.pl
 * @version $Id: config.php,v 1.5 2005/01/20 15:00:05 maroslaw Exp $
* @package    pay
* @subpackage mbank
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
@include_once ("config/auto_config/mbank_config.inc.php");
require_once("include/my_crypt.inc");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("./include/gen_mbank_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->mbank_config['bar']);

$my_crypt=new MyCrypt;
$mbank_config->mbank_pass_gpg=$my_crypt->endecrypt("",@$mbank_config->mbank_pass_gpg,"de");
$mbank_config->mbank_password=$my_crypt->endecrypt("",@$mbank_config->mbank_password,"de");


if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();

$item['back_ok']=ereg_replace("http://[a-z0-9.]+/","",@$item['back_ok']);
$item['back_error']=ereg_replace("http://[a-z0-9.]+/","",@$item['back_error']);


if (! empty($item['save'])) {
 	$pass_pgp_crypt=$my_crypt->endecrypt("",$item['pass_gpg']);
 	$password=$my_crypt->endecrypt("",$item['password']);
 	$ftp->connect();
    $gen_config->gen(array(
                           "mbank_merchant_id"=>$item['merchant_id'],
                           "mbank_email"=>$item['email'],
                           "mbank_mode"=>$item['mode'],
						   "mbank_info"=>$item['info'],
                           "mbank_server"=>$item['server'],
                           "mbank_back_ok"=>$item['back_ok'],
                           "mbank_back_error"=>$item['back_error'],
                           "mbank_pass_gpg"=>$pass_pgp_crypt,
                           "mbank_login"=>$item['login'],
                           "mbank_password"=>$password,
                           "mbank_mail_host"=>$item['mail_host'],
                           "mbank_title_email"=>$item['title_email'],
                           "mbank_no_safe"=>$item['no_safe'],                  
                           )
                     );
    $ftp->close();
    $mbank_config->mbank_merchant_id=$item['merchant_id'];
    $mbank_config->mbank_email=$item['email'];
    $mbank_config->mbank_mode=$item['mode'];
    $mbank_config->mbank_info=$item['info'];
    $mbank_config->mbank_server=$item['server'];
    $mbank_config->mbank_back_ok=$item['back_ok'];
    $mbank_config->mbank_back_error=$item['back_error'];
    $mbank_config->mbank_pass_gpg=$item['pass_gpg'];
    $mbank_config->mbank_login=$item['login'];
    $mbank_config->mbank_password=$item['password'];
    $mbank_config->mbank_mail_host=$item['mail_host'];
    $mbank_config->mbank_title_email=$item['title_email'];
    $mbank_config->mbank_no_safe=$item['no_safe'];
}

include_once ("./html/mbank_config.html.php");


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
