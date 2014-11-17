<?php
/**
* @version    $Id: offline.html.php,v 1.2 2004/12/20 17:59:59 maroslaw Exp $
* @package    main_keys
* @subpackage offline
*/
$onclick="onclick=\"window.open('','window','width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>


<?php print $lang->offline_sql_info; ?>

<center>
<form action=offline.php method=post target=window>
<center>
<form action=offline.php method=post target=window>
<table><tr>
<td><input type=radio name='money_mode' value='50'></td><td><?php print $lang->offline_money['50'];?><br></td></tr>

<tr><td><input type=radio name='money_mode' value='20'></td><td><?php print $lang->offline_money['20'];?><br></tr>

<td><input type=radio name='money_mode' value='10'></td><td><?php print $lang->offline_money['10'];?></td></tr>
</table>
<br><br>

<input type=submit name=submit_offline value='Aktualizuj dane' <?php print $onclick; ?>>
</form>
</center>
