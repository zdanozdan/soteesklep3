<?php
/**
* @version    $Id: theme.inc.php,v 1.5 2004/12/20 18:02:39 maroslaw Exp $
* @package    themes
* @subpackage blueball
*/
$config->base_theme="redball";

class MyTheme Extends Theme {
    var $img_border=0;
}

$theme = new MyTheme;
?>
