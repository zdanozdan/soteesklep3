<?php
/**
* @version    $Id: menu.inc.php,v 1.3 2004/12/20 17:59:19 maroslaw Exp $
* @package    wysiwyg
*/
print "<div align=right>";
global $config;



if (in_array("newsedit",$config->plugins)) {
    $buttons->menu_buttons(array($lang->wysiwyg["html"]=>"/go/_wysiwyg/",
                                 $lang->wysiwyg["news"]=>"/plugins/_newsedit/",
                                 $lang->wysiwyg["help"]=>"/plugins/_help_content/help_show.php?id=12 onClick=\"open_window(600,450);\" target=window"
                                )
                          );
} else {
    $buttons->menu_buttons(array($lang->wysiwyg["html"]=>"/go/_wysiwyg/"                                 
                                )
                          );
}

print "</div>";
?>
