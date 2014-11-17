<?php
/**
* Menu grup newslettera
*
* @author  rdiak@sote.pl
* @version $Id: menu.inc.php,v 2.10 2005/12/13 11:00:38 krzys Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/ 

$onclick="onclick=\"open_window(350,200)\"";

/**
* Za³±cz menu g³ówne.
*/
include_once ("../include/menu_top.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"/plugins/_newsletter/_groups/index.php",
                             $lang->newsletter_menu["search"]=>"search.php",                            
                             $lang->groups_menu["add"]=>"add.php $onclick target=window",
                             $lang->groups_menu["list"]=>"index.php",
                             $lang->help=>'/plugins/_help_content/help_show.php?id=29 onClick=\"open_window(300,500);\" target=window'                            
                             )
                       );
print "</div>";
?>
