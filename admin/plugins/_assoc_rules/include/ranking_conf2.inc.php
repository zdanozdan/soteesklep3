<?php
global $config, $_REQUEST;
require_once("include/gen_user_config.inc.php");

if (isset($_REQUEST['ranking2_max_length']) || isset($_REQUEST['ranking2_enabled'])) {
	if ($_REQUEST['ranking2_max_length'] == '')
		$ranking2_max_length = 0;
	else
		$ranking2_max_length = (int)$_REQUEST['ranking2_max_length'];

	$ranking2_enabled = 0;
	if(!empty($_REQUEST['ranking2_enabled'])) {
	    $ranking2_enabled = 1;
	}
		
    $ftp->connect();
    $gen_config->gen(
        array
        (
        "ranking2_max_length"=>$ranking2_max_length,
        "ranking2_enabled"=>$ranking2_enabled,
        )
    );
    $ftp->close();
    $config->ranking2_max_length = $ranking2_max_length;
    $config->ranking2_enabled = $ranking2_enabled;

}
?>