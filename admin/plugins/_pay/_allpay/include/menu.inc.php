<?php
/**
 * Menu modu³u ceneo pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 1.3 2006/04/25 08:45:48 krzys Exp $
* @package    pasaz.ceneo.pl
 */

global $config;

print "<div align=right>";
$buttons->menu_buttons(array(                            
                             $lang->allpay_buttons["config"]=>"/plugins/_pay/_allpay/index.php",
                             $lang->allpay_buttons["help"]=>"/plugins/_help_content/help_show.php?id=59 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help",
                             )
                       );
print "</div>";
?>
