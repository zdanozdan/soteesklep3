<?php
/**
* @version    $Id: remind.html.php,v 1.2 2007/12/01 11:15:13 tomasz Exp $
* @package    users
*/
?>
<p>

<div class="block_1">
<table width=100% align=center style="font-size:15px">
<tr>
  <td style="font-size:12px">
    <?php print $lang->users_remind_info1;?>
    <center>
    
    <form action=/go/_users/remind2.php method=post>
    <table width=100%>
    <tr><td>&nbsp</tr></td>
    <tr>
      <td style="text-align:center; font-size:12px"><b><?php print $lang->users_email;?></b>&nbsp
         <input type=text size=20 name=email>&nbsp
         <input type=submit value='<?php print $lang->users_send;?>'>
<?php
         $_SESSION['head_display'] = true;
?>
     </td> 
    </tr>
    </table>
    </form>

    </center>
    <?php print $lang->users_remind_info2;?>
  </td>
</tr>
</table>
</div>
<p>
