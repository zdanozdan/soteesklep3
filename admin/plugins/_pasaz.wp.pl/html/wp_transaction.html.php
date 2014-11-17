<?php
/**
 * Transakcje wp pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_transaction.html.php,v 1.2 2004/12/20 18:00:36 maroslaw Exp $
* @package    pasaz.wp.pl
 */
?>
<?php
$onclick="onclick=\"window.open('','wp_trans','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<br>

<form action=transaction1.php method=POST name=wp_trans target=wp_trans>
<p>
<table align=center width=95%><tr><td>
<center>
<?php  if( $count ) {
	print $lang->wp_trans['export']; 
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
 	$buttons->button($lang->wp_trans['show_trans'],"/go/_order/wp_trans.php");
	print "</td><td>";
	$buttons->button($lang->wp_trans['submit'],"javascript:document.wp_trans.submit(); $onclick");
 } else {
    print $lang->wp_trans['notrans'];
 }	
?>
</td></tr></table>
   </center>
</td></tr>
</table>
</from>
