<?php
/**
* @version    $Id: menu.inc.php,v 2.13 2006/01/03 09:15:14 lechu Exp $
* @package    options
* @subpackage available
*/

print "<div align=left>";
print "<table>\n";
print "<tr>\n";

print "<td>\n";
$buttons->button($lang->available_menu["availability"],"/go/_options/_available/");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->available_menu["depository"],"/go/_depository/");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->available_menu["deliverers"],"/go/_deliverers/");
print "</td>\n";

print "</tr>\n";
print "</table>\n";
print "</div>";


$onclick="onclick=\"open_window(425,200)\"";
print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->available_menu["add"]=>"add.php $onclick target=window",
                             $lang->available_menu["list"]=>"index.php",  
                             $lang->available_menu["configure"]=>"configure.php",  
                             $lang->help=>"/plugins/_help_content/help_show.php?id=27 onClick=\"open_window(300,500);\" target=window",                            
                             //$lang->empty_trash=>"javascript:document.FormList.submit();"
                             )
                       );
print "</div>";
?>
