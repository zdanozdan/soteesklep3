<?php
/**
 * Glowne menu "klienci"
 *
 * @author  m@sote.pl
 * @version $Id: menu_top.inc.php,v 2.2 2004/12/20 17:59:16 maroslaw Exp $
* @package    users
 */

print "\n\n<div align=left>\n";
print "<table><tr>\n";

if (in_array("newsletter",$config->plugins)) {
    print "\t<td>\n";
    $buttons->button($lang->users_main_menu['newsletter'],"/plugins/_newsletter/_users/index.php");
    print "\t</td>\n";
}

if (in_array("discounts",$config->plugins)) {
    print "\t<td>\n";
    $buttons->button($lang->users_main_menu['discounts'],"/plugins/_discounts/index.php");
    print "\t</td>\n";
}

if (in_array("sales",$config->plugins)) {
    print "\t<td>\n";
    $buttons->button($lang->users_main_menu['sales'],"/plugins/_sales/index.php");
    print "\t</td>\n";
}

print "</tr></table>\n";
print "</div>\n\n";

?>
