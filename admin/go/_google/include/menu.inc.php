<?php 
/**
* Menu dla opcji g³ównego administratora.
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 1.1 2005/08/02 10:37:23 maroslaw Exp $
* @package google
*/

print "<div align=right>";
$buttons->menu_buttons(
array(
$lang->google_menu['config']=>"config.php",
$lang->google_menu['gen']=>"index.php",
// $lang->help=>"/plugins/_help_content/help_show.php?id=22 onClick=\"open_window(300,500);\" target=window",
)
);
print "</div>";
?>
