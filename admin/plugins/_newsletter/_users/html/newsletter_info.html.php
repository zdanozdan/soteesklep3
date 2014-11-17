<?php
/**
* Informcja do³±czana do stopki newslettera. Link do wypisania siê z newslettera.
*
* Informacja jest generowana w postaci txt
* 
* @author  rdiak@sote.pl
* @version $Id: newsletter_info.html.php,v 2.12 2006/03/03 07:52:58 krzys Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

/**
* \@global string $info
*/

global $config,$_REQUEST;
$email_md5=md5($email.$config->salt);
$info=$config_newsletter->newsletter_foot."\n";
$url="http://".$config->www;
$url_remove=$url."/go/_newsletter/register.php?act=del&email=".$email_md5;
if (@$_REQUEST['item']['type']=="html") {
	print $config_newsletter->foot;
    $info="<p>$config_newsletter->newsletter_foot<br><a href=\"$url_remove\">$url_remove</a></p>\n";
} else {
    $info.=$url_remove;
}
?>
