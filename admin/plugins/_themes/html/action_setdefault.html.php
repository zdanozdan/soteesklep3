<?php
/**
* Ustawienie domy¶lnego tematu w sklepie
*
* @author     amiklosz@sote.pl
* @version    $Id: action_setdefault.html.php,v 1.6 2004/12/20 18:00:57 maroslaw Exp $
*
* \@global string $__thm temat wybrany przez klienta (klucz)
* @package    themes
*/
?>

<?php
include ("include/menu.inc.php");
$theme->bar($lang->themes_menu['after_set_theme']);

print "<p>\n";

print $lang->themes_info_default_theme_description;
$__thm=$_REQUEST['thm'];
print "<ul>\n";
$themeTxt = $config->themes[$__thm];
print "<li>$themeTxt";
print "</ul>\n";

$buttons->button($lang->themes_button_return, "/plugins/_themes/index.php");

print "</p>\n";
?>
