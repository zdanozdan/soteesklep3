<?php
/**
 * Menu
 * 
 * \@global int $__deep numer kategorii
 * 
 * @author  m@sote.pl
 * \@template_version Id: menu.inc.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.4 2004/12/20 17:58:09 maroslaw Exp $
* @package    edit_category
 */

include_once ("./include/menu_top.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array($lang->edit_category_menu["add"]=>"add.php?deep=$__deep onclick=\"open_window(450,200)\" target=window",
                             $lang->edit_category_menu["list"]=>"category$__deep.php?deep=$__deep",                            
                             // $lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
