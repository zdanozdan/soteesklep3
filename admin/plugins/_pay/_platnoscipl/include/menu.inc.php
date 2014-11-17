<?php
/**
 * Menu
 * 
 * @author  m@sote.pl
 * @version $Id: menu.inc.php,v 1.3 2005/11/14 11:31:58 scalak Exp $
* @package    pay
* @subpackage platnoscipl
 */

print "<div align=right>";
$buttons->menu_buttons(array($lang->platnoscipl_menu["setup"]=>"index.php",                             
                             $lang->platnoscipl_menu["order"]=>"/go/_order/search2.php?pay_method=20",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=50 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>
