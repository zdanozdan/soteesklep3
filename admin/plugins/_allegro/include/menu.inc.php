<?php
/**
 * Menu modu³u ceneo pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.5 2006/04/12 12:33:41 scalak Exp $
* @package    pasaz.ceneo.pl
 */

global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->allegro_options["config"]=>"/plugins/_allegro/config.php",
                             $lang->allegro_options["export"]=>"/plugins/_allegro/export.php",
                             $lang->allegro_options["send"]=>"/plugins/_allegro/list.php",
                             $lang->allegro_options["category"]=>"/plugins/_allegro/category.php",
                             $lang->allegro_options["help"]=>"/plugins/_help_content/help_show.php?id=58 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>
