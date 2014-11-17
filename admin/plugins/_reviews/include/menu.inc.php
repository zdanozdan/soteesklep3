<?php
/**
 * PHP Template:
 * Menu
 * 
 * @author piotrek@sote.pl
 * @version $Id: menu.inc.php,v 1.8 2004/12/20 18:00:52 maroslaw Exp $
* @package    reviews
 */

$onclick=$theme->onclick(360,425);


print "<table border=0><tr>";
print "<td>";$buttons->button($lang->reviews_buttons['scores'],"_scores/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->reviews_buttons['reviews'],"index.php");print "</td>\n";
print "</tr></table>";

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
                             $lang->reviews_menu["add"]=>"add.php $onclick target=window",
                             $lang->reviews_menu["list"]=>"index.php",                                                   $lang->button_help => "/plugins/_help_content/help_show.php?id=16 onClick=\"open_window(300,500);\" target=window",
                             //$lang->empty_trash=>"javascript:document.FormList.submit();",
                             )
                       );
print "</div>";
?>
