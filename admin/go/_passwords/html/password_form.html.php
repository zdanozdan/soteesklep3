<?php
/**
* @version    $Id: password_form.html.php,v 2.2 2004/12/20 17:59:00 maroslaw Exp $
* @package    passwords
*/
?>
<form action=index.php method=post>
<input type=hidden name=update value=true>

<table align=center>
<tr>
<td valign=top>

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
