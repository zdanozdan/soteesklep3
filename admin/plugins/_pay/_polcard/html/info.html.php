<?php
/**
* @version    $Id: info.html.php,v 1.3 2004/12/20 18:00:41 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/
include_once ("./include/menu.inc.php");

$theme->bar($lang->polcard_title,"100%");print "<BR>";
$theme->desktop_open("100%");

if ($config->demo=="yes") {
    $config->license['nr']="0000-0000-0000-0000-0000-0000";
}

print "<div align=right>\n";
print "<img src=";$theme->img("_icons/polcard.jpg");print ">\n";
print "</div>\n";
print "<p>";
print $lang->polcard_info_info;
print "<p>";
print $lang->polcard_info." <a href=mailto:".@$polcard_config->email.">".@$polcard_config->email."</a>.<p>";
?>

<p>

<center><a href=http://www.polcard.com.pl target=polcard><u><?php print $lang->polcard_more_info;?> www.polcard.com.pl</u></a></center>
<?php
$theme->desktop_close();
?>
