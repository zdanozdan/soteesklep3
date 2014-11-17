<?php
/**
* @version    $Id: configure.html.php,v 2.2 2005/01/03 14:59:57 lechu Exp $
* @package    dictionary
*/
print "<BR>";
$theme->desktop_open("100%");

/**
* Dodaj obs³ugê formularzy.
*/
require_once ("HTML/Form.php");
global $config,$lang;

$break="</td></tr><tr><td><hr></td></tr><tr><td align=right>";

$form =& new HTML_Form("configure.php","POST");
$form->addHidden("update","true");

$form->addCheckbox("configure[newsedit]",$lang->configure_form['newsedit'],$config->newsedit);
$form->addCheckbox("configure[rss_link]",$lang->configure_form['rss_link'],$config->rss_link);
$form->addSelect("configure[newsedit_columns_default]",$lang->configure_form['newsedit_columns_default'],$lang->newsedit_columns_default,$config->newsedit_columns_default);

$form->addSubmit("submit",$lang->update);
$form->display();

$theme->desktop_close();
?>
