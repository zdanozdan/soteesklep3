<?php
/**
* wyswietlenie menu nad konfiguracj± 
*
* @author  krzys@sote.pl
* @version $Id: menu.inc.php,v 1.5 2004/12/29 14:05:34 krzys Exp $
* @package    configure
*/

print "<div align=right>";
$data=array(
    $lang->button_catalog_conf=>"/go/_configure/catalog_conf.php",
    $lang->button_configuration=>"/go/_configure/index.php",
    $lang->button_help => "/plugins/_help_content/help_show.php?id=2 onClick=\"open_window(300,500);\" target=window",

);

$buttons->menu_buttons($data);
print "</div>";
?>
