<?php
/**
* @version    $Id: offline.html.php,v 1.3 2005/01/18 10:01:52 scalak Exp $
* @package    offline
* @subpackage attributes
*/
$onclick="onclick=\"window.open('','window','width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>


<?php print $lang->offline_sql_info; ?>

<center>
<form action=offline.php method=post target=window>
<table><tr>
<td><input type=radio name='money_mode' value='50' checked></td><td><?php print $lang->offline_money['50'];?><br></td></tr>
</table>
<br><br>

<input type=submit name=submit_offline value="<?php print $lang->offline_submit_data; ?>" <?php print $onclick; ?>>
</form>
</center>
