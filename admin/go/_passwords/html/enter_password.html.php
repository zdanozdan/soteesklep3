<?php
/**
* @version    $Id: enter_password.html.php,v 2.2 2004/12/20 17:59:00 maroslaw Exp $
* @package    passwords
*/
?>
<table align=center>
  <tr>
    <td><b><?php print $lang->auth_www_error;?></b></td>
  </tr>
    <?php exit;?>
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
