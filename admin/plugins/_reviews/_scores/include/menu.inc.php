<?php
/**
 * PHP Template:
 * Menu
 * 
 * @author m@sote.pl
 * @version $Id: menu.inc.php,v 1.4 2004/12/20 18:00:50 maroslaw Exp $
* @package    reviews
* @subpackage scores
 */


print "<table><tr>";
print "<td>";$buttons->button($lang->scores_buttons['scores'],"index.php");print "</td>\n";
print "<td>";$buttons->button($lang->scores_buttons['reviews'],"../index.php");print "</td>\n";
print "</tr></table>";

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->scores_menu["list"]=>"index.php",
                             $lang->scores_menu["export"]=>"export.php",
                             //$lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
