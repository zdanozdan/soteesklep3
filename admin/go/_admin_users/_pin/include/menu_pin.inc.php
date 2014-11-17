<?php
/**
* Menu przy zmienie PINu.
*
* @author m@sote.pl
* @version $Id: menu_pin.inc.php,v 2.2 2004/12/20 17:57:51 maroslaw Exp $
* @package    admin_users
* @subpackage pin
*/


$onclick="onclick=\"window.open('','window','width=360,height=180,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";

print "<table><tr>";
print "<td>";$buttons->button($lang->admin_users_buttons['admin_users'],"/go/_admin_users/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->admin_users_buttons['pin'],"/go/_admin_users/_pin/index.php");print "</td>\n";
print "<td>";$buttons->button($lang->admin_users_buttons['permissions'],"/go/_admin_users/_admin_users_type/index.php");print "</td>\n";
print "</tr></table>";

?>
