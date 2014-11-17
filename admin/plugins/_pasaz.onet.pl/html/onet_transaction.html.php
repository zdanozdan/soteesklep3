<?php
/**
 * Transakcje onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_transaction.html.php,v 1.7 2004/12/20 18:00:31 maroslaw Exp $
* @package    pasaz.onet.pl
 */
?>
<?php
$onclick="onclick=\"window.open('','onet_trans','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<br>

<form action=transaction1.php method=POST name=onet_trans target=onet_trans>
<p>
<table align=center width=95%><tr><td>
<center>
<?php  if( $count ) {
	print $lang->onet_trans['export']; 
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
 	$buttons->button($lang->onet_trans['show_trans'],"/go/_order/onet_trans.php");
	print "</td><td>";
	$buttons->button($lang->onet_trans['submit'],"javascript:document.onet_trans.submit(); $onclick");
 } else {
    print $lang->onet_trans['notrans'];
 }	
?>
</td></tr></table>
   </center>
</td></tr>
</table>
</from>
