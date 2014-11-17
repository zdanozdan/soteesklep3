<?php 
/**
* Menu dla opcji aktualizacji pakietu (upgrade).
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 1.7 2005/04/11 13:43:06 maroslaw Exp $
* @package    upgrade
*/

print "<div align=right>";
$data=array();
if (@$__devel) {
    // @todo $data[$lang->upgrade_devel_config]="devel_config.php";
}
$data[$lang->upgrade_updates]="index.php";
$data[$lang->upgrade_check_new]="check_new_upgrade.php";
$data[$lang->help]="/plugins/_help_content/help_show.php?id=37 onClick=\"open_window(300,500);\" target=window";

$buttons->menu_buttons($data);

print "</div>";
?>
