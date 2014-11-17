<?php
/**
* @version    $Id: default_user_config.inc.php,v 2.2 2004/12/20 18:01:28 maroslaw Exp $
* @package    default
*/


class MyConfig extends AutoConfig{
	var $db=array(
			'nobody_dbuser'=>'%F1%7D%DD5',
			'nobody_dbpassword'=>'%F3e%CC%22%03%DC',
			'admin_dbuser'=>'%CE%BC2%97',
			'admin_dbpassword'=>'%CC%A4%23%802%07',
			'dbhost'=>'%EE%7D%CA1%1B%CDI%C7%2B',
			'dbname'=>'%F1%7D%DD5%12%D6M%D8%3A%A6w'
			);
	var $ftp=array(
			'ftp_host'=>'localhost',
			'ftp_user'=>'maroslaw',
			'ftp_password'=>'%F7%96%02%B7%08%3B%A5C%D5',
			'ftp_dir'=>'/home/maroslaw/MYCVS/soteesklep2'
			);
	var $salt="f37e02d876032f4335ceb2c97a4b831c";
	var $md5_pin="81dc9bdb52d04dc20036dbd8313ed055";
	var $license=array(
			'nr'=>'2004-0224-0001-0001-3363-e1fc',
			'who'=>'SOTE'
			);
	var $auth_sign=array(
			'b1df8666fbf0c63040abc625e2ed8e69'=>'admin'
			);
	var $config_setup=array(
			'type'=>'rebuild',
			'os'=>'linux'
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
			'2'=>'4.45',
			'3'=>'4.12'
			);
	var $currency_name=array(
			'1'=>'PLN',
			'2'=>'EUR',
			'3'=>'USD'
			);
	var $category=array(
			'icons'=>'1',
			'type'=>'standard'
			);
	var $stats=array(
			'url'=>''
			);
	var $merchant=array(
			'name'=>'dhsdfhf',
			'addr'=>'dgfdg',
			'tel'=>'',
			'fax'=>'',
			'nip'=>'',
			'bank'=>''
			);
	var $order_email="m@local";
	var $from_email="m@local";
	var $newsletter_email="m@local";
	var $www="soteesklep2";
	var $currency="PLN";
	var $cd_setup=array(
			'cd'=>'0',
			'IP'=>''
			);
	var $theme="blue";
	var $themes_active=array(
			'redball'=>'on',
			'blueball'=>'on',
			'art_orange'=>'on',
			'blue'=>'on',
			'red'=>'on',
			'green'=>'on',
			'brown'=>'on'
			);
	var $record_row_type_default="long";
	var $cyfra_photo="yes";
	var $producers_category_filter="no";
	var $basket_photo="no";
	var $google=array(
			'title'=>'SOTEeSKLEP',
			'keywords'=>'sklep internetowy',
			'description'=>'sklep internetowy'
			);

} // end class MyConfig
$config = new MyConfig;
?>
