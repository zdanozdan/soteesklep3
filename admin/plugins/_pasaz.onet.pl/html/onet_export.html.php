<?php
/**
 * Strona exportu produktów do onet pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_export.html.php,v 1.9 2005/05/20 10:39:16 scalak Exp $
 *
* @package    pasaz.onet.pl
 */

$onclick="onclick=\"window.open('','onet_export','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>

<form action=export1.php method=POST name="onet_export" target=onet_export>
<input type=hidden name=export value=1>
<p>
<table align=center width=95%><tr><td>
<center>
<?php 
	if(!$dbedit->records) {
		print $lang->onet_export['noproduct'];
		print "<br><br>";
	}
?>
<?php 
if($dbedit->records) {
	print $lang->onet_export['export']; 
}
?></center>
<p>
</td></tr>
<tr><td>
<center>
<?php 
if($dbedit->records) {
	$buttons->button($lang->onet_export['submit'],"javascript:document.onet_export.submit(); $onclick");
}   
?>
</center>
</td></tr>
</table>
</from>
