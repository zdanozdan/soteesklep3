<?php
/**
* Edycja grupy adresów e-mail
*
* @author  rdiak@sote.pl
* @version $Id: newsletter_edit.html.php,v 2.10 2004/12/20 18:00:13 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage groups
*/
?>

<form action=<?php print $action;?> method=POST>
<input type=hidden name=update value=true>
<input type=hidden name=id value="<?php print @$this->id;?>">
<p>

<?php
global $max_id;
if (empty($rec->data['user_id'])) {
    if(!empty($max_id)) {
        $rec->data['user_id']=$max_id+1;
    } else {
        $rec->data['user_id']=1;
    }
}    

if (empty($this->id)) {
    $disable="";
} else {
    $disable="disabled";
    print "<input type=hidden name=item[user_id] value=".@$rec->data['user_id']."><br>"; 
} 
?>

<?php $theme->desktop_open();?>

<table align=center>
<tr>
  <td><?php print $lang->newsletter_groups['id']?></td>
  <td><input type=text size=30 name=item[user_id] value="<?php print @$rec->data['user_id'];?>" <?php print $disable; ?>><br>
    <?php $theme->form_error('user_id');?>
  </td>
</tr>

<tr>
  <td><?php print $lang->newsletter_groups['name']?></td>
  <td><input type=text size=30 name=item[name] value="<?php print @$rec->data['name'];?>"><br>
    <?php $theme->form_error('name');?>
  </td>
</tr>

<tr>
  <td></td>
  <td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>
</table>
<?php $theme->desktop_close();?>

</form>
