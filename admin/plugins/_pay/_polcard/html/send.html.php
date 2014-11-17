<?php
/**
* @version    $Id: send.html.php,v 1.3 2004/12/20 18:00:41 maroslaw Exp $
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

if ($__send==true) {
    
    if ($__result_mail==true) {
        print "<center>$lang->polcard_send_ok "."<a href=mailto:".$polcard_config->email.">".$polcard_config->email."</a></center>";
    } else {
        print "<center>$lang->polcard_send_error</center>";
    }
} else {
    print "<center>$lang->polcard_empty_posid</center>";
}

$theme->desktop_close();
?>
