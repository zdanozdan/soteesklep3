<?php
/**
* @version    $Id: theme.inc.php,v 2.5 2004/12/20 18:02:48 maroslaw Exp $
* @package    themes
* @subpackage redball
*/
$config->base_theme="redball";

class MyTheme extends Theme {
    //var $colors=array("light"=>"#111111",
    //                  "dark"=>"#999999");
}

$theme =& new MyTheme;

$config->colors['light']="#c9c9c9";
$config->colors['dark']="#646464";
?>
