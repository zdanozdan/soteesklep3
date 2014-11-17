<?php
global $config, $_REQUEST;

require_once("include/gen_user_config.inc.php");

$form = $_REQUEST['form'];
if(!empty($form['display_availability'])) {
    $config->depository['display_availability'] = 1;
}
else {
    $config->depository['display_availability'] = 0;
}


$ftp->connect();
$depository = $config->depository;
$gen_config->gen(
    array
    (
        "depository"=>$depository,
    )
);
$ftp->close();

?>