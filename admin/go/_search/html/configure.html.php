<?php
/**
* @version    $Id: configure.html.php,v 1.1 2005/10/04 09:15:00 krzys Exp $
* @package    dictionary
*/
print "<BR><CENTER>";
$theme->desktop_open("20%");
print "<div align=\"left\">";
/**
* Dodaj obs³ugê formularzy.
*/
require_once ("HTML/Form.php");
global $config,$lang;

print "<div align='center'><nobr>".$lang->search_adv_desc."</nobr></div>";

$form =& new HTML_Form("configure.php","POST");
$form->addHidden("update","true");

$form->addCheckbox("configure[by_name]",$lang->search_adv_form['by_name'],$config_search->by_name);
$form->addCheckbox("configure[by_phrase]",$lang->search_adv_form['by_phrase'],$config_search->by_phrase);
$form->addCheckbox("configure[by_price]",$lang->search_adv_form['by_price'],$config_search->by_price);
$form->addCheckbox("configure[by_price_netto_brutto]",$lang->search_adv_form['by_price_netto_brutto'],$config_search->by_price_netto_brutto);
$form->addCheckbox("configure[by_attrib]",$lang->search_adv_form['by_attrib'],$config_search->by_attrib);
$form->addCheckbox("configure[by_producer]",$lang->search_adv_form['by_producer'],$config_search->by_producer);
$form->addCheckbox("configure[by_category]",$lang->search_adv_form['by_category'],$config_search->by_category);

$form->addSubmit("submit",$lang->update);
$form->display();

$theme->desktop_close();
print "</div></CENTER>";
?>
