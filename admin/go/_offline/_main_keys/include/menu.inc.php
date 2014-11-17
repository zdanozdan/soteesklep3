<?php
/**
* @version    $Id: menu.inc.php,v 1.2 2004/12/20 17:58:34 maroslaw Exp $
* @package    offline
* @subpackage main_keys
*/
global $lang;

$load=$lang->offline_menu['load'];
$update=$lang->offline_menu['update'];
$status=$lang->offline_menu['status'];
$examples=$lang->offline_menu['examples'];

print "<div align=right>";
$buttons->button($lang->export,"export.php");
$buttons->menu_buttons(array("<<"=>"/go/_offline/",
                             $load=>"index.php",
                             $update=>"data2sql.php",
                             $status=>"status.php",
                             $examples=>"example.php",                             
		    ));
print "</div>";
?>
