<?php
/**
* wyswietlenie menu nad konfiguracją katalogu
*
* @author  krzys@sote.pl
* @version $Id: menu2.inc.php,v 1.1 2005/01/06 11:28:55 krzys Exp $
* @package    configure
*/

print "<div align=right>";
$data=array(
    $lang->button_catalog_conf=>"/go/_configure/catalog_conf.php",
    $lang->button_configuration=>"/go/_configure/index.php",
    $lang->button_help => "/plugins/_help_content/help_show.php?id=43 onClick=\"open_window(300,500);\" target=window",

    );

$buttons->menu_buttons($data);
print "</div>";
?>