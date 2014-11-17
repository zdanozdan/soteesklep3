<?php
/**
* @version    $Id: send_error.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<center>
  <table border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td><font style="color: #990000;"><?php print $lang->register_send_order_error;?></font></td>
				</tr>
				<tr>
				  <td><a href="mailto:<?php print $config->order_email;?>" style="color: #990000;"><?php print "&nbsp;".$config->order_email;?></a></td>
    </tr>
  </table>
</center>
