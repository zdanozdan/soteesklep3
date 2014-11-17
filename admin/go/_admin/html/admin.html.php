<?php
/**
* Szablon preznetacji opcji dostepnych dla g³ównego administratora.
*
* @author  m@sote.pl
* @version $Id: admin.html.php,v 1.6 2005/06/29 12:43:47 maroslaw Exp $
* @package    admin
*/

print "\n\n";
print "<table>\n";
print "<tr>\n";
print "<tr><td>";$buttons->button($lang->admin_users_buttons['admin_users'],"/go/_admin_users/index.php");print "</td></tr>\n";
print "<tr><td>";$buttons->button($lang->admin_users_buttons['pin'],"/go/_admin_users/_pin/index.php");print "</td></tr>\n";

print "<tr><td>";$buttons->button($lang->icons['help_management'],"/plugins/_help_content/index.php");print "</td>\n";
if (in_array("multi_lang",$config->plugins)) {
	print "<tr><td>";$buttons->button($lang->icons['lang_update'],"/go/_lang_editor/update.php");print "</td></tr>\n";
}
print "<tr><td>";$buttons->button($lang->admin_users_buttons["admindb"],"/go/_admin_users/_admindb/index.php");print "</td></tr>\n";
print "<tr><td>";$buttons->button($lang->admin_users_buttons["upgrade"],"/go/_upgrade/index.php");print "</td></tr>\n";
print "<tr><td>";$buttons->button($lang->admin_users_buttons["importshop"],"/go/_importshop/index.php");print "</td></tr>\n";
print "</tr>\n";
print "</table>\n\n";
?>
