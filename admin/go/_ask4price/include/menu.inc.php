<?php
/**
 * PHP Template:
 * Menu
 * 
 * @author m@sote.pl
 * \@template_version Id: menu.inc.php,v 2.1 2003/03/13 11:28:52 maroslaw Exp
 * @version $Id: menu.inc.php,v 1.2 2005/06/30 12:25:11 lechu Exp $
* @package    options
* @subpackage vat
 */

print "<div align=right>";
$buttons->menu_buttons(array(
                             $lang->help=>"/plugins/_help_content/help_show.php?id=48 onClick=\"open_window(300,500);\" target=window",
                             $lang->ask4price_list=>"/go/_ask4price/index.php",
                             )
                       );
print "</div>";
?>
