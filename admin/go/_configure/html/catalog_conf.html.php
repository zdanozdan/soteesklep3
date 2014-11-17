<?php
/**
* Formularz z elementami konfiguracji sklepu jako katalogu
*
* @author  krzys@sote.pl
* @version $Id: catalog_conf.html.php,v 1.2 2005/01/06 11:28:54 krzys Exp $
* @package    configure
* @subpackage catalog
*/

global $config; 
$theme->bar($lang->catalog_conf_title,"100%");print "<BR>";
$theme->desktop_open("100%");

print $lang->catalog_conf_text;

/*
* Dodaj obs³ugê formularzy.
*/
require_once ("HTML/Form.php");

$break="</td></tr><tr><td><hr></td></tr><tr><td align=right>";

$form =& new HTML_Form("catalog_conf.php","POST");
$form->addHidden("update","true");

print "<CENTER>";
$form->addCheckbox("configure[catalog_mode]",$lang->catalog_mode_options['catalog_mode'],$config->catalog_mode);
$form->addCheckbox("configure[catalog_mode_options_currency]",$lang->catalog_mode_options['currency'],$config->catalog_mode_options['currency']);
$form->addCheckbox("configure[catalog_mode_options_users]",$lang->catalog_mode_options['users'],$config->catalog_mode_options['users']);
$form->addCheckbox("configure[catalog_mode_options_newsletter]",$lang->catalog_mode_options['newsletter'],$config->catalog_mode_options['newsletter']);
$form->addCheckbox("configure[catalog_mode_options_newsedit]",$lang->catalog_mode_options['newsedit'],$config->catalog_mode_options['newsedit']);



$form->addSubmit("submit",$lang->update);
$form->display();
print "</CENTER>";
$theme->desktop_close();
?>
