<?php
/**
 * Menu
 * 
 * @author  pmalinski@sote.pl
 * \@template_version Id: menu.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.7 2004/12/20 18:00:25 maroslaw Exp $
* @package    partners
 */

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->partners_menu["add"]=>"add.php onclick=\"open_window(400,280)\" target=window",
                             $lang->partners_menu["list"]=>"index.php",
                             $lang->partners_menu["links"]=>"links.php",
                             $lang->partners_menu["rake_off"]=>"rake_off.php",
                             $lang->partners_menu["transactions"]=>"/go/_order/partner_trans.php",
                             $lang->partners_menu["help"]=>"/plugins/_help_content/help_show.php?id=34 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             //$lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
