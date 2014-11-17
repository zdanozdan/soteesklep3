<?php
/**
* @version    $Id: configure.html.php,v 2.8 2005/03/14 14:05:14 lechu Exp $
* @package    dictionary
* \@lang
*/
$theme->bar($lang->dictionary_configure_bar);
print ("<BR>");
$theme->desktop_open("100%");

if(!empty($message))
    echo "<br>" . $message . "<br><br>";
/**
* Dodaj obs³ugê formularzy.
*/
require_once ("HTML/Form.php");
global $config,$lang;

$break="</td></tr><tr><td><hr></td></tr><tr><td align=right>";

$form =& new HTML_Form("configure.php","POST");
$form->addHidden("update","true");

$form->addSelect("configure[lang]",$lang->dictionary_configure_lang,$config->langs_names,$config->lang_id);

reset($config->langs_names);
while (list($l_id, $l_name) = each($config->langs_names)) {
    $l_symbol = $config->langs_symbols[$l_id];
	$form->addSelect("configure[currency_lang_default_".$l_symbol."]",$lang->dictionary_configure_currency_lang_default." ".$l_name,$config->currency_name,@$config->currency_lang_default[$l_symbol]);
}
/*
foreach ($config->languages as $la) {
    $form->addSelect("configure[currency_lang_default_".$la."]",$lang->dictionary_configure_currency_lang_default." ".$config->languages_names[$la],$config->currency_name,@$config->currency_lang_default[$la]);
}
*/
reset($config->langs_names);
while (list($l_id, $l_name) = each($config->langs_names)) {
    $l_symbol = $config->langs_symbols[$l_id];
    $form->addCheckbox("configure[lang_active][".$l_symbol."]",$lang->dictionary_configure_lang_active.
    " ".$l_name . " <a href=edit_lang.php?action=edit&lang_id=$l_id style='font-weight: bold;' target=window onclick='window.open(\"\", \"window\", \"width=500, height=250, resizable=1, scrollbars=0, status=0, toolbar=0\")'>[" . $lang->edit . "]</a>",@$config->langs_active[$l_id]);
}
/*
foreach ($config->languages as $la){
    $form->addCheckbox("configure[lang_active_".$la."]",$lang->dictionary_configure_lang_active.
    " ".$config->languages_names[$la],$config->lang_active[$la]);
    
}
*/



$form->addSubmit("submit",$lang->update);
$form->display();

echo "<br><center><a href='edit_lang.php?action=add' target=window onclick='window.open(\"\", \"window\", \"width=500, height=250, resizable=1, scrollbars=0, status=0, toolbar=0\")'>";
echo $lang->dictionary_add_lang;
echo "</a></center><br>";

$theme->desktop_close();
?>
