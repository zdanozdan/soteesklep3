<!-- users_login_error.html.php --><?php
/**
* @version    $Id: users_login_error.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<div class="block_1">
<center>
  <table border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td><br/><div style="color: red;"><b><?php print $lang->users_login_error."&nbsp;".$lang->users_login_error_advice;?></b></div><br/></td>
    </tr>
  </table>
</center>
</div>
<?php
// wyswietl formularz logowania
$this->theme_file("users.html.php");
?>
