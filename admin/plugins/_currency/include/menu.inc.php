<?php
/**
* Nazwy elementow nad lista - lista walut
*
* @author  krzys@sote.pl
* @version $Id: menu.inc.php,v 2.9 2004/12/20 17:59:32 maroslaw Exp $
* @package    currency
*/

global $config;
$data=array("<<"=>"/go/_options",
    $lang->currency_menu["add"]=>"add.php onclick=\"open_window(325,125);\" target=window",
    $lang->currency_menu["list"]=>"index.php",
    $lang->currency_menu["nbp"]=>"nbp.php",
    $lang->help=>"/plugins/_help_content/help_show.php?id=28 onClick=\"open_window(300,500);\" target=window",
    );
    
if ($config->admin_lang!="pl") unset($data[$lang->currency_menu["nbp"]]);

print "<div align=right>\n";
$buttons->menu_buttons($data);
print "</div>";

?>
