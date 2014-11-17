<?php
/**
 * PHP Template:
 * Menu
 * 
 * @author m@sote.pl
 * \@template_version Id: menu.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: menu.inc.php,v 2.14 2004/12/20 17:59:37 maroslaw Exp $
* @package    dictionary
 */

include_once ("./include/menu_top.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array($lang->dictionary_menu["add"]=>"add.php onClick=\"open_window(350,350);\" target=window",
                             $lang->dictionary_menu["list"]=>"index.php",
			                 $lang->dictionary_menu["catgen"]=>"import.php",			                                 $lang->dictionary_menu["export"]=>"export.php",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=9  onClick=\"open_window(300,500);\" target=window",                     
                             )
                       );
print "</div>";

if (@$__index==true) {
    $theme->bar($lang->dictionary_list_bar2);
    print "<center>";$theme->az("index.php");print "</center>";
}
?>
