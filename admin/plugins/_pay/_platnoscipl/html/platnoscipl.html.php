<?php
/**
* Formularz konfiguracji p³atno¶ci platnoscipl.pl
*
* @author  m@sote.pl
* @version $Id: platnoscipl.html.php,v 1.3 2006/04/07 12:11:41 lukasz Exp $
* @package    pay
* @subpackage platnoscipl
*/

$forms = new Forms;

include_once ("./include/menu.inc.php");

$theme->bar($lang->platnoscipl_title,"100%");print "<BR>";
$theme->desktop_open("100%");

if ($config->demo=="yes") {
    $config->license['nr']="0000-0000-0000-0000-0000-0000";
}

print "<table>\n";
print "  <tr>\n";
print "    <td>\n";
print "      <img src=";$theme->img("_img/platnosci.gif");print ">\n";
print "    </td>\n";
print "    <td>\n";
print "<p />";

print $lang->platnoscipl_info." <a href=mailto:".@$platnoscipl_config->email.">".@$platnoscipl_config->email."</a><p>";

$forms->open("index.php");
$forms->item=0;                      // nie dodawaj "item" do nazwy pola formularza, zostaw 'nazwa' zamiast 'item[nazwa]' 
$forms->hidden("update",true);
$forms->text("item[pl_pos_id]",@$platnoscipl_config->pl_pos_id,$lang->platnoscipl['pl_posid'],16);
$forms->text("item[pl_md5_one]",@$platnoscipl_config->pl_md5_one,$lang->platnoscipl['pl_md5_one'],48);
$forms->text("item[pl_md5_two]",@$platnoscipl_config->pl_md5_two,$lang->platnoscipl['pl_md5_two'],48);

$forms->text("item[pl_url_ok]","http://".$config->www."/".@$platnoscipl_config->pl_url_ok,$lang->platnoscipl['pl_url_ok'],64);
$forms->text("item[pl_url_fail]","http://".$config->www."/".@$platnoscipl_config->pl_url_fail,$lang->platnoscipl['pl_url_fail'],64);
$forms->text("item[pl_url_check]","http://".$config->www."/".@$platnoscipl_config->pl_url_check,$lang->platnoscipl['pl_url_check'],64);

//$forms->checkbox("item[status]",@$platnoscipl_config->status,$lang->platnoscipl['status']);
$forms->checkbox("item[active]",@$platnoscipl_config->active,$lang->platnoscipl['active']);
$forms->checkbox("item[sms]",@$platnoscipl_config->sms,$lang->platnoscipl['sms']);
$forms->select("item[draw_type]",@$platnoscipl_config->draw_type,$lang->platnoscipl_draw_type_info,$lang->platnoscipl_draw_type,"1");
$forms->text("item[js_param]",@$platnoscipl_config->js_param,$lang->platnoscipl_draw_row_count,2);
$forms->button_submit("",$lang->update);
$forms->close();

print "    </td>\n";
print "  </tr>\n";
print "</table>\n";


$theme->desktop_close();
?>
