<?php
/**
 * Menu dla opcji "Edycja wygl±du". Zak³adka "Pomoc"
 *
 * @author     amiklosz@sote.pl lech@sote.pl
 * @version    $Id: menu.inc.php,v 1.6 2004/12/20 18:01:10 maroslaw Exp $
* @package    themes
 */

print "<div align=right>";
$data=array(
    @$lang->themes_titles['themes']=>"/plugins/_themes/index.php",
    @$lang->themes_titles['category']=>"/plugins/_themes/category.php",
    @$lang->help => "'javascript:window.open(\"/plugins/_help_content/help_show.php?id=35\", \"window\", \"scrollbars=1, width=600, height=400, resizable=1\"); void(0);'",
);

$buttons->menu_buttons($data);
print "</div>";

?>
