<?php
/**
 * Strona exportu produktów do interia pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: interia_export.html.php,v 1.1 2005/03/29 15:13:59 scalak Exp $
 *
* @package    pasaz.interia.pl
 */

$onclick="onclick=\"window.open('','interia_export','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>

<form action=export1.php method=POST name="interia_export" target=interia_export>
<input type=hidden name=export value=1>
<p>
<table align=center width=95%><tr><td>
<center>
<?php 
	if(!$dbedit->records) {
		print $lang->interia_export['noproduct'];
		print "<br><br>";
	}
?>
<?php 
if($dbedit->records) {
	print $lang->interia_export['export']; 
}
?></center>
<p>
</td></tr>
<tr><td>
<center>
<?php 
if($dbedit->records) {
	$buttons->button($lang->interia_export['submit'],"javascript:document.interia_export.submit(); $onclick");
}   
?>
</center>
</td></tr>
</table>
</from>
