<?php
/**
* @version    $Id: mbank_config.inc.php,v 2.4 2004/12/20 18:01:29 maroslaw Exp $
* @package    default
*/


class mBankConfig {
	var $ServiceID="0000000";
	var $email="mtransfer@mbank.pl";
	var $status="0";
	var $active="1";

} // end class mBankConfig
$mbank_config = new mBankConfig;
?>
