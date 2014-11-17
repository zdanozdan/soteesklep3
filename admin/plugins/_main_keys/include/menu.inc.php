<?php
/**
 * Menu
 * 
 * @author  m@sote.pl
 * \@template_version Id: menu.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.4 2004/12/20 18:00:02 maroslaw Exp $
* @package    main_keys
 */

include_once ("./include/menu_top.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array($lang->main_keys_menu["add"]=>"add.php onclick=\"open_window(650,200)\" target=window",
                             $lang->main_keys_menu["list"]=>"index.php",   
                             $lang->main_keys_menu["search"]=>"search.php",     
                             $lang->help=>"/plugins/_help_content/help_show.php?id=41  onClick=\"open_window(500,500);\" target=window",                                   
                             )
                       );
print "</div>";
?>
