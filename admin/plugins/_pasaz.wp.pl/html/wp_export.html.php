<?php
/**
 * Strona exportu produktów do wp pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_export.html.php,v 1.2 2004/12/20 18:00:35 maroslaw Exp $
 *
* @package    pasaz.wp.pl
 */

$onclick="onclick=\"window.open('','wp_export','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>

<form action=export1.php method=POST name="wp_export" target=wp_export>
<input type=hidden name=export value=1>
<p>
<table align=center width=95%><tr><td>
<center>
<?php 
	if(!$dbedit->records) {
		print $lang->wp_export['noproduct'];
		print "<br><br>";
	}
?>
<?php 
if($dbedit->records) {
	print $lang->wp_export['export']; 
}
?></center>
<p>
</td></tr>
<tr><td>
<center>
<?php 
if($dbedit->records) {
	$buttons->button($lang->wp_export['submit'],"javascript:document.wp_export.submit(); $onclick");
}   
?>
</center>
</td></tr>
</table>
</from>
