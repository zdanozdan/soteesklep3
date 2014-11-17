<?php
/**
* Menu
*
* @author m@sote.pl
* @version $Id: menu.inc.php,v 2.4 2004/12/20 17:57:48 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

$onclick="onclick=\"window.open('','window','width=360,height=180,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";

print "<table><tr>";
print "<td>";$buttons->button($lang->admin_users_buttons['admin_users'],"/go/_admin_users/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->admin_users_buttons['pin'],"/go/_admin_users/_pin/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->admin_users_buttons['permissions'],"/go/_admin_users/_admin_users_type/index.php");print "</td>\n";
print "</tr></table>";

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
$lang->admin_users_type_menu["add"]=>"add.php $theme->onclick target=window",
$lang->admin_users_type_menu["list"]=>"index.php",
)
);
print "</div>";
?>
