<?php
/**
 * Transakcje interia pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: interia_transaction.html.php,v 1.2 2005/03/30 13:18:15 scalak Exp $
* @package    pasaz.interia.pl
 */
?>
<?php
$onclick="onclick=\"window.open('','interia_trans','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<br>

<form action=transaction1.php method=POST name=interia_trans target=interia_trans>
<p>
<table align=center width=95%><tr><td>
<center>
<?php  if( $count ) {
	print $lang->interia_trans['export']; 
}
?>
</td></tr>
<tr><td>
<center>
<table>
<tr>
<td>   
<?php
 if( $count ) {
 	$buttons->button($lang->interia_trans['show_trans'],"/go/_order/interia_trans.php");
	print "</td><td>";
	$buttons->button($lang->interia_trans['submit'],"javascript:document.interia_trans.submit(); $onclick");
 } else {
    print $lang->interia_trans['notrans'];
 }	
?>
</td></tr></table>
   </center>
</td></tr>
</table>
</from>
