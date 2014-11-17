<?php
/**
 * Menu
 * 
 * @author  m@sote.pl
 * @version $Id: menu.inc.php,v 1.3 2005/11/30 08:58:45 lukasz Exp $
* @package    pay
* @subpackage przelewy24
 */

print "<div align=right>";
$buttons->menu_buttons(array(
							 $lang->cardpay_menu["about"]=>"info.php",                             
							 $lang->cardpay_menu["setup"]=>"index.php",                             
                             $lang->cardpay_menu["order"]=>"/go/_order/search2.php?pay_method=110",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=51 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>
