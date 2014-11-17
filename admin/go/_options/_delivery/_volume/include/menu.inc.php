<?php
/**
* Nazwy elementow nad lista - lista stref wysy³ki
*
* @author  rdiak@sote.pl
* @version $Id: menu.inc.php,v 1.6 2005/02/24 12:18:55 scalak Exp $
* @package delivery
*/

global $config;

print "<table border=0><tr>";
print "<td>";$buttons->button($lang->delivery_menu['delivery'],"../index.php");print "</td>\n";
print "<td>";$buttons->button($lang->delivery_menu['zone'],"../_zone/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->delivery_menu['volume'],"index.php");print "</td>\n";
print "<td>";$buttons->button($lang->delivery_menu['config'],"../config.php");print "</td>\n";
print "</tr></table>";

$data=array("<<"=>"/go/_options",
    $lang->delivery_volume_menu["add"]=>"add.php onclick=\"open_window(400,200);\" target=window",
    $lang->delivery_volume_menu["list"]=>"index.php",
    $lang->help=>"/plugins/_help_content/help_show.php?id=44 onClick=\"open_window(300,500);\" target=window",
    );
    
print "<div align=right>\n";
$buttons->menu_buttons($data);
print "</div>";

?>
