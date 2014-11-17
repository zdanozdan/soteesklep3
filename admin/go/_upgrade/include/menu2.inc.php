<?php 
/**
* Menu2 dla opcji aktualizacji pakietu (upgrade).
*
* @author  m@sote.pl
* @version $Id: menu2.inc.php,v 1.2 2004/12/20 17:59:12 maroslaw Exp $
* @package    upgrade
*/

print "<div align=right>";
$data=array();
$data[$lang->upgrade_updates]="index.php";
$buttons->menu_buttons($data);
print "</div>";
?>
