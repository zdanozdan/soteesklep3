<?php
/**
 * Menu glowne main_keys
 *
 * @author  m@sote.pl
 * @version $Id: menu_top.inc.php,v 1.3 2004/12/20 18:00:02 maroslaw Exp $
* @package    main_keys
 */

print "<div align=left>";
print "<table>\n";
print "<tr>\n";
// print "\t<td>";$buttons->button($lang->main_keys_menu['load'],"/go/_offline/_main_keys/index.php");print "</td>\n";
print "\t<td>";$buttons->button($lang->main_keys_menu['edit'],"/plugins/_main_keys/index.php");print "</td>\n";
print "\t<td>";$buttons->button($lang->main_keys_menu['ftp'],"/plugins/_main_keys/_main_keys_ftp/index.php");print "</td>\n";
print "</tr>\n";
print "</table>";
print "</div>";
?>
