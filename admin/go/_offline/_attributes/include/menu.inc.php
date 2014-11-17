<?php
/**
* @version    $Id: menu.inc.php,v 1.9 2004/12/20 17:58:24 maroslaw Exp $
* @package    offline
* @subpackage attributes
*/
global $lang;

$load=$lang->offline_menu['load'];
$update=$lang->offline_menu['update'];
$status=$lang->offline_menu['status'];
$examples=$lang->offline_menu['examples'];
$export=$lang->offline_menu['export'];
$help=$lang->offline_menu['help'];

include_once ("../lang/_$config->lang/lang.inc.php");
include_once ("../include/menu.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"/go/_offline/",
                             $load=>"index.php",
                             $update=>"data2sql.php",
                             $status=>"status.php",
                             $examples=>"example.php",
                             $help=>"/plugins/_help_content/help_show.php?id=11 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help"));
print "</div>";
?>
