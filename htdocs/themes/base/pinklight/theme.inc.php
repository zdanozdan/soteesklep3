<?php
/**
* @version    $Id: theme.inc.php,v 1.2 2004/12/20 18:02:45 maroslaw Exp $
* @package    themes
* @subpackage pinklight
*/
$config->base_theme="bluelight";

class MyTheme Extends Theme {
    var $img_border=0;
}

$theme = new MyTheme;
?>
