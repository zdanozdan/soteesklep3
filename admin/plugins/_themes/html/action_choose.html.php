<?php
/**
* W³±czenie obs³ugi wielu tematów
*
* @author     amiklosz@sote.pl
* @version    $Id: action_choose.html.php,v 1.7 2004/12/20 18:00:56 maroslaw Exp $
*
* \@global array $active tablica okre¶laj±ce aktywne tematy
* @package    themes
*/
?>

<?php
include_once ("include/menu.inc.php");
$theme->bar($lang->themes_menu['after_add_theme']);

print "<p>\n";
print $lang->themes_info_choosen_theme_description;
print "<ul>\n";

foreach ($active as $key_act=>$thm_act)
{
  $thm = $config->themes[$key_act];
  $themeTxt = $thm;
  print "<li>$themeTxt"."<br/>\n";
}
print "</br>\n";

$themeTxt = $config->themes[$config->theme];

$txt = $themeTxt.$lang->themes_info_default_theme;
print "<li>$txt";
print "</ul>\n";

$buttons->button($lang->themes_button_return, "/plugins/_themes/index.php");

print "</p>\n";
?>
