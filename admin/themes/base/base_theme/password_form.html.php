<?php
/**
* @version    $Id: password_form.html.php,v 1.2 2004/12/20 18:01:23 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<form action=index.php method=post>
<input type=hidden name=update value=true>

<table align=center>
<tr>
<td valign=top>


<!--
  <table align=center>
  <tr>
    <td><b><?php print $lang->auth_www;?></b></td>
  </tr>
  <tr>
    <td><?php print $lang->login;?></td>
    <td><input type=text size=8 name=auth_www[login] value="<?php print $config->dbuser;?>"><br>
    <?php $theme->form_error('login');?>
    </td>
  </tr>
  <tr>
    <td><?php print $lang->password_old;?></td>
    <td><input type=password size=16 name=auth_www[password_old]><br>
    <?php $theme->form_error('password_old');?>
    </td>
  </tr>
  <tr>
    <td><?php print $lang->password_new;?></td>
    <td><input type=password size=16 name=auth_www[password_new]><br>
    <?php $theme->form_error('password_new');?>
    </td>
  </tr>
  <tr>
    <td><?php print $lang->password_confirm;?></td>
    <td><input type=password size=16 name=auth_www[password_confirm]><br>
    <?php $theme->form_error('password_confirm');?>
    </td>
  </tr>
  <tr>
    <td></td>
    <td><input type=submit name=submit_auth_www value="<?php print $lang->password_change;?>">
  </tr>
  </table>
-->


</td>
<td valign=top>

  <table align=center>
  <tr>
    <td><b><?php print $lang->auth_ftp;?></b></td>
  </tr>
  <tr>
    <td><?php print $lang->password;?></td>
    <td><input type=password size=16 name=auth_ftp[password]></td>
  </tr>
  <tr>
    <td></td>
    <td><input type=submit name=submit_auth_ftp value="<?php print $lang->password_change;?>">
  </tr>
  </table>



</td>
</tr>
</table>

</form>
