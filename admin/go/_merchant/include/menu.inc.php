<?php
/**
 * Menu gorne zmiany danych sprzedawcy
 *
 * @author  m@sote.pl
 * @version $Id: menu.inc.php,v 1.4 2004/12/20 17:58:18 maroslaw Exp $
* @package    merchant
 */

print "<div align=right>";
$data=array(
  $lang->help => "/plugins/_help_content/help_show.php?id=21 onClick=\"open_window(300,500);\" target=window",
);

$buttons->menu_buttons($data);
print "</div>";
?>
