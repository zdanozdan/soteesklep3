<?php
/**
* @version    $Id: config_inteligo.inc.php,v 2.4 2004/12/20 18:01:28 maroslaw Exp $
* @package    default
*/


class InteligoConfig {
	var $inteligo_merchant_id="000";
	var $inteligo_email="";
	var $inteligo_mode="test";
	var $inteligo_pay_method="Ipay2";
	var $inteligo_currency="PLN";
	var $inteligo_info="zamówienie ze sklepu";
	var $inteligo_coding="md5";
	var $inteligo_server="https://secure.inteligo.com.pl/interpay";
	var $inteligo_key="";
	var $inteligo_back_ok="";
	var $inteligo_back_error="";
	var $inteligo_lock="files";

} // end class InteligoConfig
$inteligo_config = new InteligoConfig;
?>
