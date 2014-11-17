<?php
/**
* @version    $Id: polcard_url.html.php,v 1.3 2004/12/20 18:00:41 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/
include_once ("./include/menu.inc.php");

$theme->bar($lang->polcard_title,"100%");print "<BR>";
$theme->desktop_open("100%");

print "<div align=right>\n";
print "<img src=";$theme->img("_icons/polcard.jpg");print ">\n";
print "</div>\n";

print "<p>";
print $lang->polcard_info_url." <a href=mailto:$polcard_config->email>$polcard_config->email</a>.<p>";

print "<table>\n";
print "<tr><td><b>".$lang->polcard_url['true']."</b></td><td>".$__polcard_url_true."</td></tr>\n";
print "<tr><td><b>".$lang->polcard_url['false']."</b></td><td>".$__polcard_url_false."</td></tr>\n";
print "<tr><td><b>".$lang->polcard_url['error']."</b></td><td>".$__polcard_url_error."</td></tr>\n";
print "</table>";

print "<center>\n";
print $lang->polcard_send_info."<BR>";
$buttons->button($lang->polcard_send_info_submit,"send.php");
print "</center>\n";

$theme->desktop_close();
?>
