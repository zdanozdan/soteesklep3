<?php
/**
 * Menu systemu export
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.1 2005/12/22 11:40:01 scalak Exp $
* @package    offline
* @subpackage export
 */
 
 
include_once ("../lang/_$config->lang/lang.inc.php");
//include_once ("../include/menu.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array(
			$lang->export_menu["export"]=>"index.php",
            $lang->export_menu["help"]=>"/plugins/_help_content/help_show.php?id=10 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help"));
print "</div>";
?>
