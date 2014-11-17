<?php
/**
* Formularz edycji statusu transakcji.
*
* @author  m@sote.pl
* @version $Id: edit.html.php,v 2.4 2004/12/20 17:58:50 maroslaw Exp $
* @package    order
* @subpackage status
*/

/**
* Wygeneruj nowe ID jesli $this->id jest puste
*/
if (empty($id)) {
    include_once ("include/next_id.inc.php");
    $id=NextID::next("order_status","user_id");
    $rec->data['user_id']=$id;
}

global $__edit;
if (@$__edit==true) {
    $disable="disabled";
} else $disable='';

?>
<form action=<?php print $action;?> method=post>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$id;?>> 
<p>

<?php
if (! empty($disable)) {
    print "<input type=hidden name=order_status[user_id] value=".@$rec->data['user_id'].">\n";
}
?>

<table align=center>
<tr>
   <td><?php print $lang->id;?></td>
   <td><input type=text size=2 name=order_status[user_id] value="<?php print @$rec->data['user_id'];?>" <?php print $disable;?>><br>
<?php $theme->form_error('user_id');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->order_status_cols['name']?></td>
   <td><input type=text size=30 name=order_status[name] value="<?php print @$rec->data['name'];?>"><br>
<?php $theme->form_error('name');?>
   </td>
</tr>
<tr>
   <td>
        <?php
            print $lang->order_status_cols['send_mail'];
            if(@$rec->data['send_mail'] == 1)
                $check = 'checked';
        ?>
   </td>
   <td><input type=checkbox name=order_status[send_mail] <?php echo @$check; ?> value="1"><br>
<?php /*$theme->form_error('name');*/?>
   </td>
</tr>
<tr>
   <td><?php print $lang->order_status_cols['mail_title']?></td>
   <td><input type=text size=60 name=order_status[mail_title] value="<?php print @$rec->data['mail_title'];?>"><br>
<?php /*$theme->form_error('name');*/?>
   </td>
</tr>
<tr>
   <td><?php print $lang->order_status_cols['mail_content']; ?>
   </td>
   <td><textarea cols=60 rows=8 name=order_status[mail_content] ><?php print @$rec->data['mail_content'];?></textarea><br>
<?php /*$theme->form_error('name');*/?>
   </td>
</tr>
<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>
</table>

</form>
