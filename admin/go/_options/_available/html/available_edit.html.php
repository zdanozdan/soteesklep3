<?php
/**
* @version    $Id: available_edit.html.php,v 2.5 2005/11/25 11:49:59 lechu Exp $
* @package    options
* @subpackage available
*/
?>
<form action=<?php print $action;?> method=post>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$id;?>> 
<p>

<?php $theme->desktop_open();?>
<table align=center>
<tr>
   <td><?php print $lang->available_cols['user_id']?></td>
   <td><input type=text size=4 name=available[user_id] value="<?php print @$rec->data['user_id'];?>"><br>
<?php $theme->form_error('user_id');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->available_cols['name']?></td>
   <td><input type=text size=30 name=available[name] value="<?php print @$rec->data['name'];?>"><br>
<?php $theme->form_error('name');?>
   </td>
</tr>
<?php
/*
<tr>
   <td><?php print $lang->available_cols['num_from']?></td>
   <td><input type=text size=4 name=available[num_from] value="<?php print @$rec->data['num_from'];?>"><br>
   <?php $theme->form_error('num_from');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->available_cols['num_to']?></td>
   <td><input type=text size=4 name=available[num_to] value="<?php print @$rec->data['num_to'];?>"><br>
   <?php $theme->form_error('num_to');?>
   </td>
</tr>
*/
?>
<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>
</table>
</form>
<?php
global $_REQUEST;
if (@$_REQUEST['update'] == true) {
?>
<script>
window.opener.location.href = '/go/_options/_available/index.php?intervals_changed=1';
</script>
<?php
}

$theme->desktop_close();
?>