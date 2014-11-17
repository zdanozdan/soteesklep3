<?php
/**
 * Menu glowne rabatow
 *
 * @author  m@sote.pl
 * @version $Id: menu_top.inc.php,v 2.2 2004/12/20 17:59:47 maroslaw Exp $
* @package    discounts
 */

print "<div align=left>";
print "<table>\n";
print "<tr>\n";
print "\t<td>";$buttons->button($lang->discounts_main_menu['discounts'],"/plugins/_discounts/index.php");print "</td>\n";
print "\t<td>";$buttons->button($lang->discounts_main_menu['discounts_groups'],"/plugins/_discounts/_discounts_groups/index.php");print "</td>\n";
print "\t<td>";$buttons->button($lang->discounts_main_menu["export"],"/plugins/_discounts/export.php");print "</td>\n";
print "</tr>\n";
print "</table>";
print "</div>";

?>
