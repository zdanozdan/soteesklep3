<?php
/**
 * Menu
 * 
 * @author  lech@sote.pl
 * @template_version Id: menu.inc.php,v 2.5 2004/02/12 11:02:04 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.3 2005/11/25 15:00:52 lechu Exp $
 * @package soteesklep
 */

print "<div align=left>";
print "<table>\n";
print "<tr>\n";

print "<td>\n";
$buttons->button($lang->deliverers_menu["availability"],"/go/_options/_available/");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->deliverers_menu["depository"],"/go/_depository/");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->deliverers_menu["deliverers"],"/go/_deliverers/");
print "</td>\n";

print "</tr>\n";
print "</table>\n";
print "</div>";

print "<div align=right>";
$buttons->menu_buttons(array(
                             $lang->deliverers_menu["add"]=>"add.php onclick=\"open_window(450,200)\" target=window",
                             $lang->deliverers_menu["list"]=>"index.php",
                             $lang->help=>"/plugins/_help_content/help_show.php?id=53 onClick=\"open_window(300,500);\" target=window",
                             // $lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>