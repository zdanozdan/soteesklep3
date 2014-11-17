<?php
/**
 * Menu
 * 
 * @author  p@sote.pl
 * @version $Id: menu.inc.php,v 1.3 2004/12/20 18:00:39 maroslaw Exp $
* @package    pay
* @subpackage mbank
 */

print "<div align=right>";
$buttons->menu_buttons(array($lang->mbank_menu["setup"]=>"config.php",
                             #$lang->mbank_menu["url"]=>"url.php",
                             $lang->mbank_menu["info"]=>"info.php",
                             $lang->mbank_menu["order"]=>"/go/_order/search2.php?pay_method=5",
                             )
                       );
print "</div>";
?>
