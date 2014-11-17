<?php
/**
* Menu systemu newsletter.
*
* @author  rdiak@sote.pl
* @version $Id: menu.inc.php,v 2.11 2005/12/13 10:59:33 krzys Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

$onclick="onclick=\"open_window(400,400)\"";

/**
* Do³±cz menu g³ówne.
*/
include_once ("../include/menu_top.inc.php");

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"/plugins/_newsletter/_users/index.php",
                             $lang->newsletter_menu["search"]=>"search.php",                            
                             $lang->newsletter_menu["add"]=>"add.php $onclick target=window",
                             $lang->newsletter_menu["list"]=>"index.php",                            
                             $lang->newsletter_menu["send"]=>"send.php", 
                             $lang->help=>'/plugins/_help_content/help_show.php?id=29 onClick=\"open_window(300,500);\" target=window'                           
                             )
                       );
                       

print "</div>";
?>
