<?php
/**
* Menu
*
* @author  m@sote.pl
* \@template_version Id: menu.inc.php,v 2.4 2004/02/12 10:36:32 maroslaw Exp
* @version $Id: menu.inc.php,v 1.4 2004/12/20 18:00:07 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

include_once ("../lang/_$config->lang/lang.inc.php");
include_once ("../include/menu_top.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"..",
$lang->newsedit_groups_menu["add"]=>"add.php onclick=\"open_window(450,250)\" target=window",
$lang->newsedit_groups_menu["list"]=>"index.php",
)
);
print "</div>";
?>
