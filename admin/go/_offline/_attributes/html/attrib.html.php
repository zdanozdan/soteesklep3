<?php
/**
* @version    $Id: attrib.html.php,v 1.2 2004/12/20 17:58:21 maroslaw Exp $
* @package    offline
* @subpackage attributes
*/
global $__PHP_AUTH_PW;
$onclick="onclick=\"window.open('','window','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$sess_file=md5($__PHP_AUTH_PW.$global_auth_sign);
?>


<?php $theme->html_file("attrib_info.html.php");?>

<center>
<form action=/cgi-bin/data2sql/update_cgi.pl method=post target=window>
<input type=hidden name=auth_session value="<?php print $sess_file;?>">
<input type=hidden name=action value="load_attrib">
<input type=submit name=submit_offline value='Aktualizuj atrybuty' <?php print $onclick; ?>>
</form>
</center>
