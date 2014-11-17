<?php
/**
* @version    $Id: menu.inc.php,v 1.3 2004/12/20 18:00:38 maroslaw Exp $
* @package    pay
* @subpackage inteligo
*/
global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->inteligo_menu["config"]=>"config.php",
                             //$lang->inteligo_menu["url"]=>"url.php",
                             $lang->inteligo_menu["info"]=>"info.php",
                             $lang->inteligo_menu["order"]=>"/go/_order/search2.php?pay_method=4"
                             )
                       );
print "</div>";
?>
