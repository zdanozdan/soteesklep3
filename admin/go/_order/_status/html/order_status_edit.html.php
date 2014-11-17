<?php
/**
* Formularz edycji statusu transakcji.
*
* @author  m@sote.pl
* @version $Id: order_status_edit.html.php,v 2.3 2004/12/20 17:58:50 maroslaw Exp $
* @package    order
* @subpackage status
*/
?>
<form action=<?php print $action;?> method=post>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$id;?>> 
<p>

<table align=center>
<tr>
   <td><?php print $lang->order_status_cols['name']?></td>
   <td><input type=text size=30 name=order_status[name] value="<?php print @$rec->data['name'];?>"><br>
<?php $theme->form_error('name');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->order_status_cols['user_id']?></td>
   <td><input type=text size=2 name=order_status[user_id] value="<?php print @$rec->data['user_id'];?>"><br>
<?php $theme->form_error('user_id');?>
   </td>
</tr>
<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>
</table>

</form>
