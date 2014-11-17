<?php
/**
 * Menu modu³u pasaz.interia.pl
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.2 2005/11/24 11:22:34 scalak Exp $
* @package    pasaz.interia.pl
 */


global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->interia_options["config"]=>"/plugins/_pasaz.interia.pl/config.php",
                             $lang->interia_options["export"]=>"/plugins/_pasaz.interia.pl/export.php",
                             $lang->interia_options["category"]=>"/plugins/_pasaz.interia.pl/category.php",
                             $lang->interia_options["trans"]=>"/plugins/_pasaz.interia.pl/transaction.php",
                             $lang->interia_options["help"]=>"/plugins/_help_content/help_show.php?id=54 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>
