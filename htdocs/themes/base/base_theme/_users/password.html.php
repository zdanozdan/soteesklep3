<?php
/**
* @version    $Id: password.html.php,v 1.2 2007/12/01 11:14:49 tomasz Exp $
* @package    users
*/
?>
<div class="block_1">
<table width=100% align=center><tr><td style="text-align:center">
<?php print $lang->users_password_info;?>
</td></tr></table>

<table width=100% align=center>
<tr>

<form action=/go/_users/password.php method=post>
<input type=hidden name=update value=true>

<td>
  <table width=100% align=center>
  <tr>
  <td style="text-align:right"><B><?php print $lang->users_old_password;?>:</B></td><td><input type=password size=16 name=item[old_password]  value='<?php $this->form_val("old_password");?>'><br />
  <?php $this->form_error('old_password');?>
  </td>
  </tr>
  <tr> 
  <td style="text-align:right"><B><?php print $lang->users_new_password; ?>:</B></td><td><input type=password size=16 name=item[password]  value='<?php $this->form_val("password");?>'><br />
  <?php $this->form_error('password');?>
  </td>
  </tr>
  <tr>
  <td style="text-align:right"><B><?php print $lang->users_password_confirm;?>:</B></td><td><input type=password size=16 name=item[password2]  value='<?php $this->form_val("password2");?>'><br />
    <?php $this->form_error('password2');?>
  </td>
  </tr>
  <tr><td></td><td align=right><input type=submit value=<?php print $lang->users_change_password;?>></td></tr>
  </table>
</td>
</tr>
</table>

</form>
</div>
