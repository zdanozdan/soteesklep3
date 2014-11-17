<?php
/**
 * Menu przy edycji/dodawaniu rekordu
 * 
 * @author  m@sote.pl
 * @version $Id: menu_edit_add.inc.php,v 1.2 2004/12/20 18:00:46 maroslaw Exp $
* @package    promotions
 */

print "<div align=right>";
$buttons->menu_buttons(array(
                             $lang->promotions_menu["add"]=>"add.php"
                             #$lang->promotions_menu["help"]=>"help.php"
                             )
                       );
print "</div>";
?>
