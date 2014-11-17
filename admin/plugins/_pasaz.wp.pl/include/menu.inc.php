<?php
/**
 * Menu modu³u pasaz.wp.pl
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.4 2004/12/20 18:00:36 maroslaw Exp $
* @package    pasaz.wp.pl
 */


global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->wp_options["config"]=>"/plugins/_pasaz.wp.pl/config.php",
                             $lang->wp_options["export"]=>"/plugins/_pasaz.wp.pl/export.php",
                             $lang->wp_options["category"]=>"/plugins/_pasaz.wp.pl/category.php",
                             $lang->wp_options["trans"]=>"/plugins/_pasaz.wp.pl/transaction.php",
                             $lang->wp_options["help"]=>"/plugins/_help_content/help_show.php?id=39 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>
