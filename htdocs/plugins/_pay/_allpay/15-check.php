<?php
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("$DOCUMENT_ROOT/../include/head.inc");
include_once ("config/auto_config/allpay_config.inc.php");
include_once("include/metabase.inc");
include_once("./include/online.inc.php");
$allpay=new AllpayOnline;
?>