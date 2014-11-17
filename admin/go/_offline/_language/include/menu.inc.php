<?php
/**
 * Menu systemu offline
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.1 2005/04/21 07:12:07 scalak Exp $
* @package    offline
* @subpackage main
 */

global $lang;

$load=$lang->offline_menu['load'];
$update=$lang->offline_menu['update'];
$status=$lang->offline_menu['status'];
$examples=$lang->offline_menu['examples'];
$help=$lang->offline_menu['help'];
$export=$lang->offline_menu['export'];
include_once ("../lang/_$config->lang/lang.inc.php");

//include_once ("../include/menu.inc.php");
print "<div align=left>";
print "<table>\n";
print "<tr>\n";
print "<td>\n";
$buttons->button($export,"/go/_offline/_language/_export/index.php");
print "</td>\n";
print "</tr>\n";
print "</table>\n";
print "</div>";

print "<div align=right>";
$buttons->menu_buttons(array(
                             $load=>"index.php",
                             $update=>"data2sql.php",
                             $status=>"status.php",
                             $examples=>"example.php",
                             $help=>"/plugins/_help_content/help_show.php?id=4 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help"));

print "</div>";
?>
