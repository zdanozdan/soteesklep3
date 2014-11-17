<?php
/**
* Menu g³ówne w offline. Wybór systemów aktualizacji cennik, atrybuty.
*
* @author  rdiak@sote.pl m@sote.pl
* @version $Id: menu.inc.php,v 2.13 2005/12/22 11:42:21 scalak Exp $
* @package    offline
*/

print "<div align=left>";
print "<table>\n";
print "<tr>\n";

print "<td>\n";
$buttons->button($lang->offline_menu['main'],"/go/_offline/_main/index.php");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->offline_menu['export'],"/go/_offline/_export/index.php");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->offline_menu['attributes'],"/go/_offline/_attributes/index.php");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->offline_menu['language'],"/go/_offline/_language/index.php");
print "</td>\n";
print "<td>\n";
$buttons->button($lang->offline_menu['depository'],"/go/_offline/_depository/index.php");
print "</td>\n";

print "</tr>\n";
print "</table>\n";
print "</div>";
?>
