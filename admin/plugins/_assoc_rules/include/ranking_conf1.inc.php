<?php
global $config, $_REQUEST;
require_once("include/gen_user_config.inc.php");

if (isset($_REQUEST['ranking1_max_length']) || isset($_REQUEST['ranking1_enabled'])) {
	if ($_REQUEST['ranking1_max_length'] == '')
		$ranking1_max_length = 0;
	else
		$ranking1_max_length = (int)$_REQUEST['ranking1_max_length'];

	$ranking1_enabled = 0;
	if(!empty($_REQUEST['ranking1_enabled'])) {
	    $ranking1_enabled = 1;
	}
	
    $ftp->connect();
    $gen_config->gen(
        array
        (
        "ranking1_max_length"=>$ranking1_max_length,
        "ranking1_enabled"=>$ranking1_enabled,
        )
    );
    $ftp->close();
    $config->ranking1_max_length = $ranking1_max_length;
    $config->ranking1_enabled = $ranking1_enabled;

}
?>