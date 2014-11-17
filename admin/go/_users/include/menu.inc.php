<?php
/**
* Menu - zarz±dzanie klientami.
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 2.10 2004/12/20 17:59:16 maroslaw Exp $
* @package    users
*/

/* Dodaj menu g³ówne */
include_once ("./include/menu_top.inc.php");

print "<div align=right>";
$data=array(
            //$lang->users["add"]=>"add.php onClick=\"open_window(780,580);\" target=window",
            $lang->users["list"]=>"index.php",
            $lang->users["search"]=>"search.php",
            $lang->help => "/plugins/_help_content/help_show.php?id=18 onClick=\"open_window(300,500);\" target=window"          
            );
$buttons->menu_buttons($data);
print "</div>";
?>
