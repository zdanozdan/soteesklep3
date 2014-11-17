<?php
/**
* @version    $Id: menu.inc.php,v 2.23 2005/03/30 12:48:14 scalak Exp $
* @package    admin_plugins
*/
global $config,$lang;

$tab=array();

print "<div align=right>";
/*
if (in_array("market",$config->plugins)) {
    $tab[$lang->plugins_name['market']]="/plugins/_market/";
}
if (in_array("newsletter",$config->plugins)) {
    $tab[$lang->plugins_name['newsletter']]="/plugins/_newsletter/_users/index.php";
}

if (in_array("discounts",$config->plugins)) {
    $tab[$lang->plugins_name['discounts']]="/plugins/_discounts/index.php";
}

if (in_array("partners",$config->plugins)) {
    $tab[$lang->plugins_name['partners']]="/plugins/_partners/index.php";
}

if (in_array("reviews",$config->plugins)) {
    $tab[$lang->plugins_name['reviews']]="/plugins/_reviews/index.php";
}

if (in_array("multi_lang",$config->plugins)) {
    $tab[$lang->plugins_name['multi_lang']]="/plugins/_dictionary/index.php";
}

if (in_array("promotion",$config->plugins)) {
    $tab[$lang->plugins_name['promotion']]="/plugins/_promotions/index.php";
}

if ((in_array("pasaz.onet.pl",$config->plugins)) && ($config->lang=="pl"))  {
    $tab[$lang->plugins_name['onet']]="/plugins/_pasaz.onet.pl/index.php";
}

if ((in_array("pasaz.wp.pl",$config->plugins))  && ($config->lang=="pl"))  {
    $tab[$lang->plugins_name['wp']]="/plugins/_pasaz.wp.pl/index.php";
}

if ((in_array("pasaz.interia.pl",$config->plugins))  && ($config->lang=="pl"))  {
    $tab[$lang->plugins_name['interia']]="/plugins/_pasaz.interia.pl/index.php";
}

if (in_array("reviews",$config->plugins)) {
    $tab[$lang->plugins_name['reviews']]="/plugins/_reviews/index.php";
}

if (in_array("cd",$config->plugins)) {
    $tab[$lang->plugins_name['cd']]="/plugins/_cd/index.php";
}
*/
$tab[$lang->help]="/plugins/_help_content/help_show.php?id=24 onClick=\"open_window(300,500);\" target=window";
$buttons->menu_buttons($tab);

print "</div>";
?>
