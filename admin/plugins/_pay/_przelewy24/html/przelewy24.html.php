<?php
/**
* Formularz konfiguracji p³atno¶ci przelewy24.pl
*
* @author  m@sote.pl
* @version $Id: przelewy24.html.php,v 1.2 2004/12/20 18:00:42 maroslaw Exp $
* @package    pay
* @subpackage przelewy24
*/

$forms = new Forms;

include_once ("./include/menu.inc.php");

$theme->bar($lang->przelewy24_title,"100%");print "<BR>";
$theme->desktop_open("100%");

if ($config->demo=="yes") {
    $config->license['nr']="0000-0000-0000-0000-0000-0000";
}

print "<table>\n";
print "  <tr>\n";
print "    <td>\n";
print "      <img src=";$theme->img("_img/przelewy24.jpg");print ">\n";
print "    </td>\n";
print "    <td>\n";
print "<p />";

print $lang->przelewy24_info." <a href=mailto:".@$przelewy24_config->email.">".@$przelewy24_config->email."</a><p>";

$forms->open("index.php");
$forms->item=0;                      // nie dodawaj "item" do nazwy pola formularza, zostaw 'nazwa' zamiast 'item[nazwa]' 
$forms->hidden("update",true);
$forms->text("item[posid]",@$przelewy24_config->posid,$lang->przelewy24['posid'],16);
$forms->checkbox("item[status]",@$przelewy24_config->status,$lang->przelewy24['status']);
$forms->checkbox("item[active]",@$przelewy24_config->active,$lang->przelewy24['active']);
$forms->button_submit("",$lang->update);
$forms->close();

print "    </td>\n";
print "  </tr>\n";
print "</table>\n";


$theme->desktop_close();
?>
