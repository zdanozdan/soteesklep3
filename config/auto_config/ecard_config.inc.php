<?php


class ecardConfig extends AutoConfig{
	var $ecardAccount="";
	var $ecardPassword="";
	var $ecardReturnUrl="go/_register/_ecard/confirm.php";
	var $ecardCancelReturnUrl="go/_register/_ecard/confirm_false.php";
	var $ecardServerHash="https://pay.ecard.pl:443/servlet/HS";
	var $ecardServerPay="https://pay.ecard.pl:443/payment/PS";
	var $ecardPayType="ALL";
	var $ecardLang="PL";
	var $ecardActive="";
	var $ecardStatus="";
	var $ecardAddressCheck="go/_register/_ecard/check.php";

} // end class ecardConfig
$ecard_config = new ecardConfig;
?>