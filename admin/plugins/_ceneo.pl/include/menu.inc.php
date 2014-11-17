<?php
/**
 * Menu modu³u ceneo pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.6 2006/08/16 10:41:42 lukasz Exp $
* @package    pasaz.ceneo.pl
 */

global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             //$lang->ceneo_options["config"]=>"/plugins/_ceneo.pl/config.php",
                             $lang->ceneo_options["export"]=>"/plugins/_ceneo.pl/export.php",
                             //$lang->ceneo_options["category"]=>"/plugins/_ceneo.pl/category.php",
                             //$lang->ceneo_options["trans"]=>"/plugins/_ceneo.pl/transaction.php",

                             $lang->ceneo_options["help"]=>"/plugins/_help_content/help_show.php?id=57 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",

                             )
                       );
print "</div>";
?>
