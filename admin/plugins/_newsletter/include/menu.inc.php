<?php
/**
* Menu g³ówne systemu newsletter
*
* @author  rdiak@sote.pl
* @version $Id: menu.inc.php,v 2.10 2004/12/20 18:00:21 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
*/

global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->newsletter_options["users"]=>"/plugins/_newsletter/_users/index.php",
                             $lang->newsletter_options["groups"]=>"/plugins/_newsletter/_groups/index.php",
                             $lang->newsletter_options["send"]=>"/plugins/_newsletter/_users/send.php",                       
                             $lang->newsletter_options["config"]=>"/plugins/_newsletter/_users/config.php",             
$lang->help=>"/plugins/_help_content/help_show.php?id=29 onClick=\"open_window(300,500);\" target=window",           
                             )
                       );
print "</div>";
?>
