<?php
/**
* Menu edycji GG
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 1.1 2006/02/13 14:20:16 maroslaw Exp $
* @package gg
*/


print "<div align=right>";
$buttons->menu_buttons(array(
$lang->gg_menu["config"]=>"index.php",
$lang->help=>"/plugins/_help_content/help_show.php?id=47 onClick=\"open_window(500,500);\" target=window",  
)
);
print "</div>";
?>