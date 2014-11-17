<?php
$onclick="onclick=\"open_window(450,350)\"";

print "<table border=0><tr>";
print "<td>";$buttons->button($lang->delivery_menu['delivery'],"index.php");print "</td>\n";
print "<td>";$buttons->button($lang->delivery_menu['zone'],"_zone/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->delivery_menu['volume'],"_volume/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->delivery_menu['config'],"config.php");print "</td>\n";
print "</tr></table>";



print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
							 $lang->delivery_menu["add"]=>"add.php $onclick target=window",
                             $lang->delivery_menu["list"]=>"index.php",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=26 onClick=\"open_window(300,500);\" target=window",  
                             // $lang->empty_trash=>"javascript:document.FormList.submit();"
                             )
                       );
print "</div>";
?>

