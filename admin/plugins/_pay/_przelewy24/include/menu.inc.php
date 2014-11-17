<?php
/**
 * Menu
 * 
 * @author  m@sote.pl
 * @version $Id: menu.inc.php,v 1.4 2004/12/20 18:00:43 maroslaw Exp $
* @package    pay
* @subpackage przelewy24
 */

print "<div align=right>";
$buttons->menu_buttons(array($lang->przelewy24_menu["setup"]=>"index.php",                             
                             $lang->przelewy24_menu["order"]=>"/go/_order/search2.php?pay_method=12",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=38 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>
