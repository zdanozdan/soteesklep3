<?php
/**
* @version    $Id: info.html.php,v 1.2 2004/12/20 18:00:37 maroslaw Exp $
* @package    pay
* @subpackage inteligo
*/
include_once ("./include/menu.inc.php");

$theme->bar($lang->inteligo_config['bar'],"100%");print "<BR>";
$theme->desktop_open("100%");

if ($config->demo=="yes") {
    $config->license['nr']="0000-0000-0000-0000-0000-0000";
}

print "<div align=right>\n";
print "Inteligo";
print "<img src=";$theme->img("_icons/inteli-sm.gif");print ">\n";
print "</div>\n";
print "<p>";
print $lang->inteligo_info_info;
?>

<p>

<center><a href=http://<?php print $lang->inteligo_url; ?> target=inteligo><u><?php print $lang->inteligo_more_info;?> <?php print $lang->inteligo_url; ?></u></a></center>
<?php
$theme->desktop_close();
?>
