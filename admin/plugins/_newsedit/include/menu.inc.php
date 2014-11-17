<?php
/**
* Menu listy newsów.
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 2.10 2005/01/03 15:00:10 lechu Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

print "<div align=right>";
$buttons->menu_buttons(array("<<"=>"/go/_text/",
                             $lang->newsedit_menu["add"]=>"add.php onClick=\"open_window(760,850);\" target=window",
                             $lang->newsedit_menu["list"]=>"index.php", 
                             $lang->help=>"/plugins/_help_content/help_show.php?id=25 onClick=\"open_window(300,500);\" target=window",  
                             
                             )
                       );
print "</div>";
?>
