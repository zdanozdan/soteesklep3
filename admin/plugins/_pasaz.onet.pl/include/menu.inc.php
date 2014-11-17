<?php
/**
 * Menu modu³u onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.9 2004/12/20 18:00:31 maroslaw Exp $
* @package    pasaz.onet.pl
 */

global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->onet_options["config"]=>"/plugins/_pasaz.onet.pl/config.php",
                             $lang->onet_options["export"]=>"/plugins/_pasaz.onet.pl/export.php",
                             $lang->onet_options["category"]=>"/plugins/_pasaz.onet.pl/category.php",
                             $lang->onet_options["trans"]=>"/plugins/_pasaz.onet.pl/transaction.php",

                             $lang->onet_options["help"]=>"/plugins/_help_content/help_show.php?id=5 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",

                             )
                       );
print "</div>";
?>
