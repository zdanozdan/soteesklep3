<?php
/**
 * PHP Template:
 * Menu
 * 
 * @author m@sote.pl
 * \@template_version Id: menu.inc.php,v 2.1 2003/03/13 11:28:52 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.5 2004/12/20 17:58:44 maroslaw Exp $
* @package    options
* @subpackage vat
 */

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->vat_menu["add"]=>"add.php onclick=\"open_window(450,150)\" target=window",
                             $lang->vat_menu["list"]=>"index.php",                                                        $lang->help=>"/plugins/_help_content/help_show.php?id=31 onClick=\"open_window(300,500);\" target=window",
                             //$lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
