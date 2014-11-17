<?php


class paypalConfig extends AutoConfig{
	var $payPalAccount="";
	var $payPalCompany="";
	var $payPalReturnUrl="plugins/_pay/_paypal/back.php";
	var $payPalCancelReturnUrl="plugins/_pay/_paypal/error.php";
	var $payPalServerUrl="https://secure.paypal.com/cgi-bin/webscr";
	var $payPalActive="";
	var $payPalStatus="";
	var $payPalServerTestUrl="https://www.sandbox.paypal.com/cgi-bin/webscr";

} // end class paypalConfig
$paypal_config = new paypalConfig;
?>