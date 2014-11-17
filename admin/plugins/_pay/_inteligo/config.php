<?php
/**
* @version    $Id: config.php,v 1.7 2005/01/20 15:00:05 maroslaw Exp $
* @package    pay
* @subpackage inteligo
*/
// +----------------------------------------------------------------------+
// | SOTEeSKLEP version 2                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1999-2002 SOTE www.sote.pl                             |
// +----------------------------------------------------------------------+
// | Inteligo  platnosci przez internet - konfiguracja                                   |
// +----------------------------------------------------------------------+
// | authors:     Robert Diak <rdiak@sote.pl>                             |
// +----------------------------------------------------------------------+
//
// $Id: config.php,v 1.7 2005/01/20 15:00:05 maroslaw Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once("./include/gen_inteligo_config.inc.php");
require_once("include/metabase.inc");
@include_once("config/auto_config/config_inteligo.inc.php");
require_once("include/my_crypt.inc");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->inteligo_config['bar']);

$my_crypt=new MyCrypt;
$inteligo_config->inteligo_key=$my_crypt->endecrypt("",@$inteligo_config->inteligo_key,"de");

if (! empty($_REQUEST['item'])) {
	$item=$_REQUEST['item'];
} else $item=array();


$item['back_ok']=ereg_replace("http://[a-z0-9.]+/","",@$item['back_ok']);
$item['back_error']=ereg_replace("http://[a-z0-9.]+/","",@$item['back_error']);

if (! empty($item['save'])) {
	$item['key_crypt']=$my_crypt->endecrypt("",$item['key']);
	$ftp->connect();
	$gen_config->gen(array(
			"inteligo_merchant_id"=>$item['merchant_id'],
			"inteligo_email"=>$item['email'],
			"inteligo_mode"=>$item['mode'],
			"inteligo_pay_method"=>$item['pay_method'],
			"inteligo_currency"=>$item['currency'],
			"inteligo_info"=>$item['info'],
			"inteligo_coding"=>@$item['coding'],
			"inteligo_server"=>$item['server'],
			"inteligo_key"=>$item['key_crypt'],
			"inteligo_back_ok"=>$item['back_ok'],
			"inteligo_back_error"=>$item['back_error'],
			"inteligo_lock"=>$item['lock'],
	                           "inteligo_number"=>$item['number'],
		)
	);
	$ftp->close();
	$inteligo_config->inteligo_merchant_id=$item['merchant_id'];
	$inteligo_config->inteligo_email=$item['email'];
	$inteligo_config->inteligo_mode=$item['mode'];
	$inteligo_config->inteligo_pay_method=$item['pay_method'];
	$inteligo_config->inteligo_currency=$item['currency'];
	$inteligo_config->inteligo_info=$item['info'];
	$inteligo_config->inteligo_coding=@$item['coding'];
	$inteligo_config->inteligo_server=$item['server'];
	$inteligo_config->inteligo_key=$item['key'];
	$inteligo_config->inteligo_back_ok=$item['back_ok'];
	$inteligo_config->inteligo_back_error=$item['back_error'];
	$inteligo_config->inteligo_lock=$item['lock'];
	$inteligo_config->inteligo_number=$item['number'];
}

require_once ("./html/inteligo_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");

?>
