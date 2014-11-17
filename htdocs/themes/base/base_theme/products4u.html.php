<?php
global $global_id_user, $DOCUMENT_ROOT, $config;
if($config->ranking2_enabled == 1) {
    include_once ("plugins/_users/_products4u/include/products4u.inc.php");
    
    //if(is_file($DOCUMENT_ROOT . "/go/_users/config/ranking/" . $global_id_user . "_config.inc.php")) {
    if(!empty($products4u->user_ranking) && (count($products4u->user_ranking) > 0)) {
    	echo "<br>";
    	$this->win_top($lang->products4u_title,760,1,1);
    //	include ("./config/ranking/" . $global_id_user . "_config.inc.php");
    //	include ("./config/ranking/306_config.inc.php");
    	include ("./include/products4u.inc.php");
    	
    /*	
    	echo "<pre>";
    	print_r($user_ranking);
    	echo "</pre>";
    */
    	$this->win_bottom(760);
    	echo "<br>";
    }
}
?>