<?php
/**
* @version    $Id: theme.inc.php,v 1.2 2004/12/20 18:02:42 maroslaw Exp $
* @package    themes
* @subpackage bluelight
*/
$config->base_theme="redball";

class MyTheme Extends Theme {
    var $img_border=0;
}

$theme = new MyTheme;
?>
