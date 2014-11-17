<?php
/**
 * Strona exportu produktów do ceneo pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: ceneo_export.html.php,v 1.3 2006/04/20 09:09:51 scalak Exp $
 *
* @package    pasaz.ceneo.pl
 */

$onclick="onclick=\"window.open('','ceneo_export','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>

<form action=export1.php method=POST name="ceneo_export" target=ceneo_export>
<input type=hidden name=export value=1>
<p>
<table align=center width=95%><tr><td>
<center>
<?php 
	if(!$dbedit->records) {
		print $lang->ceneo_export['noproduct'];
		print "<br><br>";
	}
?>
<?php 
if($dbedit->records) {
	print $lang->ceneo_export['export']; 
}
?></center>
<p>
</td></tr>
<tr><td>
<center>
<?php 
if($dbedit->records) {
	$buttons->button($lang->ceneo_export['submit'],"javascript:document.ceneo_export.submit(); $onclick");
}   
?>
</center>
</td></tr>
</table>
</from>
