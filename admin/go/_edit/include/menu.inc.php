<?php
/**
* Menu edycji produktow
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 2.25 2006/04/19 12:12:05 scalak Exp $
* @subpacke edit
*
* \@global int $id id produktu
* @package    edit
*/

global $config;

$menu=array();

print "<div align=left>\n";
print "<table><tr>\n";

print "\t<td>\n";
$buttons->button($lang->edit_menu['allegro'],"edit_allegro.php?id=$id");
print "\t</td>\n";

print "\t<td>\n";
$buttons->button($lang->edit_menu['ceneo.pl'],"edit_ceneo.php?id=$id");
print "\t</td>\n";

print "</tr></table>\n";
print "</div>";


print "<table width=100% cellspacing=0 cellpadding=0><tr><td width=15></td><td align=left>";

if ($config->admin_lang!="en"){
if (in_array("pasaz.onet.pl",$config->plugins)){
    $menu[$lang->edit_menu['pasaz.onet.pl']]="edit_onet.php?id=$id";
}
if (in_array("pasaz.wp.pl",$config->plugins)) {
    $menu[$lang->edit_menu['pasaz.wp.pl']]="edit_wp.php?id=$id";
}

if (in_array("pasaz.interia.pl",$config->plugins)) {
    $menu[$lang->edit_menu['pasaz.interia.pl']]="edit_interia.php?id=$id";
}


if(count($menu) > 0)
    $buttons->menu_buttons($menu);
}

print "</td><td align=right>";

$menu=array();
$menu[$lang->edit_menu['edit']]="index.php?id=$id";
if (in_array("multi_lang",$config->plugins)) {
	$menu[$lang->edit_lang_versions]="description_lang.php?id=$id";
}
$menu[$lang->edit_menu['add']]="add.php";
$menu[$lang->edit_menu['category']]="category.php?id=$id";
$menu[$lang->edit_menu['setup']]="setup.php?id=$id";
$menu[$lang->edit_menu['google']]="google.php?id=$id";
$menu[$lang->edit_menu['help']]="/plugins/_help_content/help_show.php?id=17";


$buttons->menu_buttons($menu);

print "</td></tr></table>";

?>
