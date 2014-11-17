<?php
global $config, $_REQUEST;

require_once("include/gen_user_config.inc.php");

$form = $_REQUEST['form'];
if(!empty($form['show_unavailable'])) {
    $config->depository['show_unavailable'] = 1;
}
else {
    $config->depository['show_unavailable'] = 0;
}


if(!empty($form['return_on_cancel'])) {
    $config->depository['return_on_cancel'] = 1;
}
else {
    $config->depository['return_on_cancel'] = 0;
}


if(isset($form)) {
    $config->depository['general_min_num'] = $form['general_min_num'];
    $config->depository['update_num_on_action'] = $form['update_num_on_action'];
    $config->depository['available_type_to_hide'] = $form['available_type_to_hide'];
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