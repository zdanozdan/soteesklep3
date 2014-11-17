<?php
/**
* @version    $Id: reminder.html.php,v 1.3 2004/12/20 18:02:33 maroslaw Exp $
* @package    users
*/
?>
<br />
<center>
  <table border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td align="center">
        <?php print $this->add_rec_top;?>
      </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#dddddd"><img src="<?php $this->img("_img/_mask.gif");?>" width="1" height="1"></td>
    </tr>
    <tr> 
      <td> 
        <table border="0" cellspacing="0" cellpadding="0" align="center">
          <?php $this->user_reminder->showReminders();?>
        </table>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#dddddd"><img src="<?php $this->img("_img/_mask.gif");?>" width="1" height="1"></td>
    </tr>
    <tr> 
      <td><br>
        <br>
      </td>
    </tr>
    <tr> 
      <td align="center"> 
        <?php print $this->add_rec_bottom;?>
      </td>
    </tr>
  </table>
</center>
