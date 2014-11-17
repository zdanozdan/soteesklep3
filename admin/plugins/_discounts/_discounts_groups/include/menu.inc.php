<?php
/**
 * PHP Template:
 * Menu
 * 
 * @author m@sote.pl
 * \@template_version Id: menu.inc.php,v 2.1 2003/03/13 11:28:52 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.6 2005/12/13 13:57:28 lechu Exp $
* @package    discounts
* @subpackage discounts_groups
 */

$onclick="onclick=\"window.open('','window','width=550,height=420,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";

include_once ("../include/menu_top.inc.php");

print "<div align=right>";

if (in_array("users_sales",$config->plugins)) {
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->discounts_groups_menu["add"]=>"add.php $onclick target=window",
                             $lang->discounts_groups_menu["list"]=>"index.php", 
                             $lang->discounts_groups_menu["update"]=>"update_dg.php",
                             $lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );

} else {
    $buttons->menu_buttons(array("<<"=>"..",
                                 $lang->discounts_groups_menu["add"]=>"add.php $onclick target=window",
                                 $lang->discounts_groups_menu["list"]=>"index.php", 
                                 'Happy hour - ' . $lang->help=>"/plugins/_help_content/help_show.php?id=56  onClick=\"open_window(300,500);\" target=window",
                                 $lang->empty_trash=>"javascript:document.FormList.submit();",
                                 )
                           );
}
print "</div>";
?>
