<?php
/**
 * Menu
 * 
 * @author  m@sote.pl
 * \@template_version Id: menu.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.6 2004/12/20 18:00:45 maroslaw Exp $
* @package    promotions
 */

print "<div align=right>";
$buttons->menu_buttons(array(
                             $lang->promotions_menu["add"]=>"add.php onclick=\"open_window(746,600)\" target=window",
                             $lang->promotions_menu["list"]=>"index.php",                                                 $lang->help=>"/plugins/_help_content/help_show.php?id=32 onClick=\"open_window(300,500);\" target=window",
                             //$lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
