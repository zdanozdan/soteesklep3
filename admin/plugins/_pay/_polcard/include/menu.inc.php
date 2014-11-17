<?php
/**
 * Menu
 * 
 * @author  m@sote.pl
 * @version $Id: menu.inc.php,v 1.5 2004/12/20 18:00:42 maroslaw Exp $
* @package    pay
* @subpackage polcard
 */

print "<div align=right>";
$buttons->menu_buttons(array($lang->polcard_menu["setup"]=>"index.php",
                             $lang->polcard_menu["url"]=>"url.php",
                             $lang->polcard_menu["info"]=>"info.php",
                             $lang->polcard_menu["order"]=>"/go/_order/search2.php?pay_method=3",
$lang->help=>"/plugins/_help_content/help_show.php?id=33 onClick=\"open_window(300,500);\" target=window",                             
                             )
                       );
print "</div>";
?>
