<?php
/**
* @version    $Id: info.html.php,v 1.2 2004/12/20 18:00:39 maroslaw Exp $
* @package    pay
* @subpackage mbank
*/
require_once ("config/auto_config/mbank_config.inc.php");
include_once ("./include/menu.inc.php");

$theme->bar($lang->mbank_title,"100%");print "<BR>";
$theme->desktop_open("100%");

if ($config->demo=="yes") {
    $config->license['nr']="0000-0000-0000-0000-0000-0000";
}

print "<div align=right>\n";
print "<img src=";$theme->img("_icons/mbank.jpg");print ">\n";
print "</div>\n";
print "<p>";

print $lang->mbank_info_info;
print "<p>";
print $lang->mbank_info." <a href=mailto:".@$mbank_config->email.">".@$mbank_config->email."</a>.<p>";
?>

<p>

<center><a href=http://www.mbank.com.pl/oferta/mtransfer/index.html target=polcard><u><?php print $lang->mbank_more_info;?> http://www.mbank.com.pl/oferta/mtransfer/index.html</u></a></center>
<?php
$theme->desktop_close();
?>
