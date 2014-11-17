<?php
/**
* @version    $Id: main.html.php,v 1.24 2006/03/14 12:09:31 krzys Exp $
* @package    admin_plugins
*/
?>
<BR>
<table border="0" cellpadding="0" cellspacing="0" width="75%" align="center">
    
    <tr align="left">    
        <td width="33%" valign="top">
<?php
if (in_array("newsletter",$config->plugins)) {
	$permf->a("<u>".$lang->icons['newsletter']."</u><BR>","/plugins/_newsletter/_users/index.php");
}
if (in_array("discounts",$config->plugins)) {
    $permf->a("<u>".$lang->icons['discounts']."</u><BR>","/plugins/_discounts/index.php");
}
if (in_array("partners",$config->plugins)) {
    $permf->a("<u>".$lang->icons['partners']."</u><BR>","/plugins/_partners/index.php");
}
if (in_array("multi_lang",$config->plugins)) {
    $permf->a("<u>".$lang->icons['lang']."</u><BR>","/plugins/_dictionary/index.php");
}
if (in_array("reviews",$config->plugins)) {
    $permf->a("<u>".$lang->icons['reviews']."</u><BR>","/plugins/_reviews/index.php");
}
if (in_array("promotion",$config->plugins)) {
    $permf->a("<u>".$lang->icons['promotions']."</u><BR>","/plugins/_promotions/index.php");
}
/*
if ($config->lang=="pl") {
    $permf->a("<u>".$lang->icons['gg']."</u><BR>","/plugins/_gg/index.php");
}*/

?>
        </td>
        <td width="33%" valign="top">
<?php
if ((in_array("pasaz.onet.pl",$config->plugins)) && ($config->lang=="pl")) {
    $permf->a("<u>".$lang->icons['onet']."</u><BR>","/plugins/_pasaz.onet.pl/index.php");
} 
if ((in_array("pasaz.wp.pl",$config->plugins)) && ($config->lang=="pl"))  {
    $permf->a("<u>".$lang->icons['wp']."</u><BR>","/plugins/_pasaz.wp.pl/index.php");
}
if ((in_array("pasaz.interia.pl",$config->plugins)) && ($config->lang=="pl"))  {
    $permf->a("<u>".$lang->icons['interia']."</u><BR>","/plugins/_pasaz.interia.pl/index.php");
}
if ((in_array("ceneo.pl",$config->plugins)) && ($config->lang=="pl"))  {
    $permf->a("<u>".$lang->icons['ceneo']."</u>","/plugins/_ceneo.pl/index.php");
}

?>
        </td>
        <td width="33%" valign="top">
<?php
if (in_array("cd",$config->plugins)) {
    $permf->a("<u>".$lang->icons['cd']."</u><BR>","/plugins/_cd/index.php");
}
$permf->a("<u>".$lang->icons['catalog_mode']."</u>","/go/_configure/catalog_conf.php");
print "<br>";
$permf->a("<u>".$lang->icons['google']."</u>","/go/_google/config.php");
if ($config->nccp=="0x1388"){ 
print "<br>";
$permf->a("<u>".$lang->icons['assoc_rules']."</u>","/plugins/_assoc_rules/index.php");
}
print "<br>";

$permf->a("<u>".$lang->icons['basket_wishlist']."</u>","/plugins/_basket_wishlist/index.php");
if (in_array("platnoscipl",$config->plugins)) {
    print "<br>";   
    $permf->a("<u>".$lang->icons['platnoscipl']."</u><BR>","/plugins/_pay/_platnoscipl/index.php");
}
if ($config->nccp=="0x1388"){ 
$permf->a("<u>".$lang->icons['allegro']."</u>","/plugins/_allegro/index.php");
}

?>
        </td>

    </tr>   
       
</table>
