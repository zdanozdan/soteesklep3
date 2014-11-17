<!-- users_go2registere.html.php --><?php
/**
* @version    $Id: users_go2register.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<br>
<div class="block_1">
<center>
  <table align="center" cellpadding="0" cellspacing="0" border="0">
    <tr> 
      <td align="center"><?php print $lang->users_order_register_desc;?></td>
    </tr>
    <tr>
      <td align="center">
         <br>
        <form action="/go/_basket/index.php?step=2" method="post">
          <input type="submit" value="<?php print $lang->users_take_order;?>">
        </form>
      </td>
    </tr>
  </table>
</center>
</div>
