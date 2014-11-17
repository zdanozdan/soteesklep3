<?php


class platnosciplConfig extends AutoConfig{
	var $pl_pos_id="2716";
	var $pl_md5_one="56111b23e457b13e3b9576c045986439";
	var $pl_md5_two="505594d656b4e6951801d3249baa17b4";
	var $pl_url_ok="plugins/_pay/_platnoscipl/confirm.php?SESSIONID=%sessionId%";
	var $pl_url_fail="plugins/_pay/_platnoscipl/confirm_false.php?SESSIONID=%sessionId%";
	var $pl_url_check="plugins/_pay/_platnoscipl/check.php";
	var $status="";
	var $active="";
	var $draw_type="radioimg";
	var $js_param="";
	var $sms="";

} // end class platnosciplConfig
$platnoscipl_config = new platnosciplConfig;
?>