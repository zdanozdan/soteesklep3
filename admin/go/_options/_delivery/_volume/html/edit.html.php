<?php
/**
* Szablon prezentujacy dane poszczegolnej waluty.
*
* 
* @version $Id: edit.html.php,v 1.2 2005/02/09 13:56:01 scalak Exp $
* @package currency
* 
*/
?>
<form action=<?php print $action;?> method=POST>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$this->id;?>> 
<p>

<?php
$onclick="onclick=\"window.open('','window1','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<table align=center>
<tr>
   <td><?php print $lang->delivery_volume_cols['name']?></td>
   <td><input type=text size=10 name=item[name] value="<?php print @$rec->data['name'];?>"><br>
   <?php $theme->form_error('name');?>
   </td>
</tr>

<tr>
	<td><?php print $lang->delivery_volume_cols['range_max']?></td>
	<td>
   <input type=text size=10 name=item[range_max] value="<?php print @$rec->data['range_max'];?>"><br>
    <?php $theme->form_error('range_max');?>
	</td>
</tr>

<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>

</table>

</form>