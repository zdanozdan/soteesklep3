<?php
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("$DOCUMENT_ROOT/../include/head.inc");
include_once ("$DOCUMENT_ROOT/../include/metabase.inc");
global $mdbd;
$p24_session=$_REQUEST['sess_id'];
$order_id=$mdbd->select('order_id','order_register',"session_id='$p24_session'",'','LIMIT 1');
if (!empty($order_id)) {
	$session=$mdbd->select('data','order_session',"order_id='$order_id'");
	if (!empty($session)) {
		$_SESSION=unserialize($session);
		// zapalamy flage
		$session_restored=true;
	}
}
require_once ("include/order_register.inc");

include_once ("config/auto_config/platnoscipl_config.inc.php");
// klasa funckji zwiazanych z platnoscipl - inicjacja obiektu $planosciPL
require_once("include/platnoscipl/online.inc.php");

$online=new PlatnosciPLOnline();
$online->action();

?>