<?php
/**
 * Menu
 * 
 * @author  p@sote.pl
 * @version $Id: menu.inc.php,v 1.2 2005/03/01 14:03:13 scalak Exp $
 * @package soteesklep
 */

print "<div align=right>";
$buttons->menu_buttons(array($lang->paypal_menu["setup"]=>"index.php",
                             $lang->paypal_menu["order"]=>"/go/_order/search2.php?pay_method=101",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=45 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>

