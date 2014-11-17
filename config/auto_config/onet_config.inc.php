<?php


class OnetConfig {
	var $onet_shop_id="";
	var $onet_mode="true";
	var $onet_login="";
	var $onet_password="";
	var $onet_server="partnerzy.pasaz.onet.pl";
	var $onet_rpc="/soap/servlet/rpcrouter";
	var $onet_message="/soap/servlet/messagerouter";
	var $onet_port="80";
	var $onet_transaction="/transaction";
	var $onet_category=array(
                );
	var $onet_confirm_trans="plugins/_pasaz.onet.pl/check.php";
	var $onet_test_server="test.pasaz.onet.pl";
	var $onet_load="product";
	var $onet_partner_name="onet";

} // end class OnetConfig
$onet_config = new OnetConfig;
?>