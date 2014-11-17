<?php
/**
* @version    $Id: menu.inc.php,v 2.3 2004/12/20 17:59:07 maroslaw Exp $
* @package    text
*/
print "<div align=right>";
global $config;



if (in_array("newsedit",$config->plugins)) {
    $buttons->menu_buttons(array($lang->text["html"]=>"/go/_text/",
                                 $lang->text["news"]=>"/plugins/_newsedit/"
                                )
                          );
} else {
    $buttons->menu_buttons(array($lang->text["html"]=>"/go/_text/"                                 
                                )
                          );
}

print "</div>";
?>
