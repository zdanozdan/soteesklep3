<?php


class allpayConfig extends AutoConfig{
	var $allpay_id="11487 ";
	var $allpay_url="plugins/_pay/_allpay/back.php";
	var $allpay_urlc="plugins/_pay/_allpay/check.php";
	var $allpay_active="1";
	var $allpay_status="0";
	var $allpay_ch_lock="0";
	var $allpay_onlinetransfer="1";
	var $allpay_channel="6";
	var $allpay_type="3";
	var $allpay_txtguzik="Powr�t do serwisu";
	var $allpay_buttontext="Kliknij, aby potwierdzi� dokonanie p�atno�ci";
	var $allpay_out_url="https://ssl.allpay.pl";

} // end class allpayConfig
$allpay_config = new allpayConfig;
?>