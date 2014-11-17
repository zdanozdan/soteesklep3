<!-- users_new.html.php --><?php
/**
* @version    $Id: users_new.html.php,v 1.2 2007/12/01 11:04:02 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<center>
<div class="block_1">
  <br />
  <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
    <tr> 
      <td style="text-align:left; font-size:12px"> 
        <?php $this->file("user_registration.html","");?>
      </td>
    </tr>
  </table>
		<br />
  <form action=/go/_users/new.php method=post>
    <input type=hidden name=type value=new_user>
    <input type=hidden name=form[check_login] value=true>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
      <tr> 
        <td valign="top" align="center"> 
	  <br />
          <table cellpadding="0" cellspacing="3" border="0" align="center" width=100%>
            <tr> 
                 <td style="text-align:center;font-size:12px">&nbsp</td>
                 <td style="text-align:left;font-size:12px"><?php print $lang->users_register;?>:</td>
            </tr>
            <tr> 
              <td style="text-align:right"><b><?php print $lang->users_login_email;?>:</b>&nbsp;</td>
              <td><input type="text" size="30" name="form[login]"  value="<?php print $form['login'];?>"><?php print "<br />\n";$this->form_error('login');?></td>
            </tr>
            <tr> 
              <td style="text-align:right"><b><?php print $lang->users_password;?>:</b>&nbsp;</td>
              <td><input type="password" size="30" name="form[password]" value="<?php print $form['password'];?>"><?php print "<br />\n";$this->form_error('password');?></td>
            </tr>
            <tr> 
              <td style="text-align:right"><b><?php print $lang->users_password_confirm;?>:</b>&nbsp;</td>
              <td><input type=password size=30 name=form[password2]  value='<?php print $form['password2'];?>'><?php print "<br />\n";$this->form_error('password2');?></td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
              <td style="text-align:left"><input type="submit" value="<?php print $lang->users_continue;?>"></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </form>
		<br />
  <table width="100%" border="0" cellspacing="5" cellpadding="0" align="center">
    <tr>
     <td style="text-align:center">&raquo;&nbsp;<a href=/go/_users/><?php print $lang->users_login_name;?></a>&nbsp;&laquo;</td>
    </tr>
  </table>
  </div>
</center>
