<?php
/**
* @version    $Id: menu_top.inc.php,v 1.2 2004/12/20 17:58:13 maroslaw Exp $
* @package    edit_producer
*/
print "<table><tr>\n";
for ($i=1;$i<=5;$i++) {
    print "<td>";
    $buttons->button($lang->edit_category_menu_list["category$i"],"/go/_edit_category/category$i.php?deep=$i");
    print "</td>\n";
}
print "<td>";
$buttons->button($lang->edit_category_menu_list["producers"],"/go/_edit_producer/index.php");
print "</td>";
print "</tr></table>\n";
?>
