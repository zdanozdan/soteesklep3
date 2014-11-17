<?php
/**
 * Menu
 * 
 * @author  lech@sote.pl
 * \@template_version Id: menu.inc.php,v 2.5 2004/02/12 11:02:04 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.3 2004/12/20 17:59:51 maroslaw Exp $
* @package    help_content
 */

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->help_content_menu["add"]=>"add.php onclick=\"open_window(450,600)\" target=window",
                             $lang->help_content_menu["list"]=>"index.php",                            
                             // $lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
