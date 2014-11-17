<?php
/**
* Formularz przes³ania transakcji rozliczonych przez pasa¿.onet.pl do Onet'u.
*
* @author  rdiak@sote.pl
* @version $Id: onet.html.php,v 2.3 2004/12/20 17:58:53 maroslaw Exp $
* @package    order
*/

$onclick="onclick=\"window.open('','window','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$sess_file=md5($_SERVER['PHP_AUTH_PW'].$global_auth_sign);
?>


<?php $theme->html_file("onet_info.html.php");?>

<center>
<form action=/cgi-bin/data2sql/update_cgi.pl method=post target=window>
<input type=hidden name=auth_session value="<?php print $sess_file;?>">
<input type=hidden name=action value="trans_onet">

<input type=submit name=submit_offline value='Prze¶lij Transakcje' <?php print $onclick; ?>>
</form>
</center>
