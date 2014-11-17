<?php
/**
* Menu g³ówme transkacji.
*
* @author  m@sote.pl
* @version $Id: menu_top.inc.php,v 2.2 2004/12/20 17:58:56 maroslaw Exp $
* @package    order
*/

print "<div align=left>\n";
print "<table width=100%>\n";
print "<tr>\n";
print "<td align=left>\n";
print "  <table><tr>";
// print "    <td>";$buttons->button($lang->order_menu['config'],"config.php");print "</td>";
// print "    <td>";$buttons->button($lang->export,"export.php");print "</td>";
print "    <td>";$buttons->button($lang->order_buttons['order'],"/go/_order/index.php");print "</td>\n";
print "    <td>";$buttons->button($lang->order_buttons['status'],"/go/_order/_status/index.php");print "</td>\n";
print "  </table>";
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</div>\n";

?>
