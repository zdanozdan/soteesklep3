<?php
/**
* Menu edycji statusów transkacji.
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 2.4 2004/12/20 17:58:52 maroslaw Exp $
* @package    order
* @subpackage status
*/

print "<div align=right>";
$buttons->menu_buttons(array(
                             $lang->order_status_menu["add"]=>"add.php onClick=\"open_window(400,250);\" target=window",
                             $lang->order_status_menu["list"]=>"index.php",                            
                             // $lang->empty_trash=>"javascript:document.FormList.submit();"
                             )
                       );
print "</div>";
?>
