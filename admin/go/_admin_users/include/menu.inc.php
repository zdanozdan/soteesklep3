<?php
/**
* Menu w panelu administratora. Zarz±dzanie dostêpem do sklepu.
*
* @author m@sote.pl
* @version $Id: menu.inc.php,v 2.15 2004/12/20 17:57:52 maroslaw Exp $
* @package    admin_users
*/


$onclick="onclick=\"window.open('','window','width=360,height=180,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";

print "<table><tr>";
print "<td>";$buttons->button($lang->admin_users_buttons['admin_users'],"/go/_admin_users/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->admin_users_buttons['permissions'],"/go/_admin_users/_admin_users_type/index.php");print "</td>\n";
print "</tr></table>\n";

print "<div align=right>";
$buttons->menu_buttons(array
(
//$lang->admin_users_menu["admindb"]=>"_admindb/index.php",
$lang->admin_users_menu["add"]=>"add.php $onclick target=window",
$lang->admin_users_menu["list"]=>"index.php",
$lang->help=>"/plugins/_help_content/help_show.php?id=36 onClick=\"open_window(300,500);\" target=window",
)
);
print "</div>";
?>
