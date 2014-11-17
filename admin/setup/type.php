<?php
/**
 * Wywo³aj opowiedni± stronê w zale¿no¶ci od rodzaju wywo³anej opcji instlacji
 * 
 * @author  m@sote.pl
 * @version $Id: type.php,v 2.8 2005/01/20 15:00:14 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    setup
 */

$global_database=false;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head.inc");

// odczytaj typ instalacji
if (! empty($_REQUEST['config']['type'])) {
    $type=$_REQUEST['config']['type'];
    $config_setup=$_REQUEST['config'];
    $sess->register("config_setup",$config_setup);
} elseif (@$_REQUEST['type']=="rebuild") {
    $config_setup=$config->config_setup;  
    $type=$_REQUEST['type'];
    $config_setup['type']=$type;
    $sess->register("config_setup",$config_setup);
} else {
    die ("Forbidden: Unknown config[type]");
}

// naglowek
// $theme->theme_file("head_setup.html.php");

switch ($type) {
 case "simple": include_once ("simple_1.php");        
     break;
 case "rebuild": include_once ("simple_1.php");
     break;
 default: include_once ("simple_1.php");
     break;
}

// $theme->theme_file("foot_setup.html.php");

// stopka
include_once ("include/foot.inc");
?>
