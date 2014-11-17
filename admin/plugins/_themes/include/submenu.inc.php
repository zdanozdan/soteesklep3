<?php
/**
 * Menu dla opcji "Edycja wygl±du". Zak³adka "Pomoc"
 *
 * @author     amiklosz@sote.pl lech@sote.pl
 * @version    $Id: submenu.inc.php,v 1.5 2004/12/20 18:01:10 maroslaw Exp $
* @package    themes
 */

print "<div align=right>";
$data=array(
  $lang->buttons_edit_theme =>"action_edit.php?thm=$thm",
  $lang->buttons_edit_colors =>"action_edit_colors.php?thm=$thm",
  $lang->help =>"'javascript:window.open(\"/plugins/_help_content/help_show.php?id=14\", \"window\", \"scrollbars=1, width=600, height=400, resizable=1\"); void(0);'",
);

$buttons->menu_buttons($data);
print "</div>";

?>
