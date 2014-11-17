<?php
/**
* @version    $Id: config.inc.php,v 2.9 2005/02/02 10:48:56 maroslaw Exp $
* @package    setup
*/
$config->setup_plugins=array("newsedit","hidden_price","in_category","polcard","ecard","mbank");
$config->setup_langs=array("pl"=>"Polski",
"en"=>"English"
);

// zmieñ jêzyk wybrany z listy na pocz±tku instalacji
$lc=0;
if (! empty($_SESSION['global_lang'])) {
    $global_lang=$_SESSION['global_lang'];
    $config->lang=$global_lang;
} elseif (! empty($_REQUEST['lang'])) {
    $global_lang=$_REQUEST['lang'];
    $config->lang=$global_lang;
}


?>