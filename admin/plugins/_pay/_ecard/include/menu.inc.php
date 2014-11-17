<?php
/**
 * Menu
 * 
 * @author  p@sote.pl
 * @version $Id: menu.inc.php,v 1.1 2005/11/29 14:18:52 scalak Exp $
 * @package soteesklep
 */

print "<div align=right>";
$buttons->menu_buttons(array($lang->ecard_menu["setup"]=>"index.php",
                             $lang->ecard_menu["order"]=>"/go/_order/search2.php?pay_method=2",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=55 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>

