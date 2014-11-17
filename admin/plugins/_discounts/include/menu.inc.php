<?php
/**
 * PHP Template:
 * Menu
 * 
 * @author m@sote.pl
 * \@template_version Id: menu.inc.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: menu.inc.php,v 2.10 2004/12/20 17:59:47 maroslaw Exp $
* @package    discounts
 */

include_once ("./include/menu_top.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->discounts_menu["import"]=>"import.php",                            
                             $lang->discounts_menu["categories"]=>"categories.php",
                             $lang->discounts_menu["producers"]=>"producers.php",
                             $lang->discounts_menu["cat_producers"]=>"index.php",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=19 onClick=\"open_window(300,500);\" target=window",
                             // $lang->discounts_menu["options"]=>"options.php",
                             // $lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
