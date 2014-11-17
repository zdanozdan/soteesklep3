<?php
/**
* @version    $Id: polcard.html.php,v 1.5 2005/12/19 08:52:18 krzys Exp $
* @package    pay
* @subpackage polcard
*/
$forms = new Forms;

include_once ("./include/menu.inc.php");

$theme->bar($lang->polcard_title,"100%");print "<BR>";
$theme->desktop_open("100%");

if ($config->demo=="yes") {
    $config->license['nr']="0000-0000-0000-0000-0000-0000";
}

print "<div align=right>\n";
print "<img src=";$theme->img("_icons/polcard.gif");print " width=147 height=31>\n";
print "</div>\n";
print "<p>";

print $lang->polcard_info." <a href=mailto:".@$polcard_config->email.">".@$polcard_config->email."</a>.<p>";

$forms->open("index.php");
$forms->item=0;                      // nie dodawaj "item" do nazwy pola formularza, zostaw 'nazwa' zamiast 'item[nazwa]' 
$forms->hidden("update",true);
$forms->text("item[posid]",@$polcard_config->posid,$lang->polcard['posid'],16);
$forms->checkbox("item[status]",@$polcard_config->status,$lang->polcard['status']);
$forms->checkbox("item[active]",@$polcard_config->active,$lang->polcard['active']);
$forms->button_submit("",$lang->merchant_update);
$forms->close();
$theme->desktop_close();
?>
