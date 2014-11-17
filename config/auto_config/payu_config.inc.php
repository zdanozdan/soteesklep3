<?php
/**
* @version    $Id: payu_config.inc.php,v 1.3 2004/12/20 18:01:30 maroslaw Exp $
* @package    default
*/
class PayUConfig {
    
	var $ServiceID="000000";
	var $email="nobody@localhost";
	var $shop_name="SOTEeSKLEP";
	var $status="1";
	var $active="1";

} // end class PayUConfig
$payu_config = new PayUConfig;
?>
