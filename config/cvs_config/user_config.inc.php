<?php
/**
* @version    $Id: user_config.inc.php,v 1.2 2004/12/20 18:01:33 maroslaw Exp $
* @package    default
*/


class MyConfig extends AutoConfig{
	var $db=array(
			'nobody_dbuser'=>'%F1%7D%DD5',
			'nobody_dbpassword'=>'%F3e%CC%22%03%DC',
			'admin_dbuser'=>'J%06%9C%60',
			'admin_dbpassword'=>'H%1E%8Dw%1D%F3',
			'dbhost'=>'%EE%7D%CA1%1B%CDI%C7%2B',
			'dbname'=>'%F1%7D%DD5%12%D6M%D8%3A%A6w'
			);
	var $ftp=array(
			'ftp_host'=>'localhost',
			'ftp_user'=>'maroslaw',
			'ftp_password'=>'s%2C%AC%40%27%CF%E0%92M',
			'ftp_dir'=>'/usr/home/maroslaw/MYCVS/soteesklep2'
			);
	var $salt="f37e02d876032f4335ceb2c97a4b831c";
	var $md5_pin="e807f1fcf82d132f9bb018ca6738a19f";
	var $license=array(
			'nr'=>'2003-0908-0001-0000-41b2-ef79',
			'who'=>'SOTE'
			);
	var $auth_sign=array(
			'b1df8666fbf0c63040abc625e2ed8e69'=>'admin'
			);
	var $config_setup=array(
			'type'=>'simple',
			'os'=>'linux',
			'host'=>'local'
			);
	var $order_points="22";
	var $available=array(
			'1'=>'jest',
			'2'=>'2 dni',
			'8'=>'8 dni',
			'9'=>'14 dni'
			);
	var $currency_data=array(
			'1'=>'1',
			'2'=>'4.9',
			'3'=>'4.12'
			);
	var $currency_name=array(
			'1'=>'PLN',
			'2'=>'EUR',
			'3'=>'USD'
			);
	var $category=array(
			'icons'=>'1',
			'type'=>'treeview'
			);
	var $stats=array(
			'url'=>''
			);
	var $merchant=array(
			'name'=>'',
			'addr'=>'',
			'tel'=>'',
			'fax'=>'',
			'nip'=>'',
			'bank'=>''
			);
	var $order_email="m@local";
	var $from_email="m@local";
	var $newsletter_email="m@local";
	var $www="www.soteesklep2.com";
	var $currency="PLN";

} // end class MyConfig
$config = new MyConfig;
?>
