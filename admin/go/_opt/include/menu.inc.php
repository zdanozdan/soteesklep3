<?php
/**
 * Menu optymalizacji
 *
 * @author  rdiak@sote.pl
 * @version $Id: menu.inc.php,v 2.6 2004/12/20 17:58:38 maroslaw Exp $
* @package    opt
 */
 
print "<div align=right>";
$buttons->menu_buttons(array(
            $lang->opt_menu["help"]=>"/plugins/_help_content/help_show.php?id=13 onClick=\"window.open('','help','width=300,height=500,scrollbars=1');\" target=help"));
print "</div>";
?>
