<!-- login_form.html.php -->
<table>
<tr> 
<td align="center">
   <div id="login_form_left">
   <form action=<?php print $this->login_action ?> method="post">
   <input type="hidden" name="type" value="login">
   <input type="hidden" name="form[check_login]" value="true">
   <?php 
   if ($this->bad_login == true)
       print "<span style=\"font: 12px Tahoma;color:#FF0000\">".$lang->users_login_order_error."</span>";
   else
       print $lang->users_login_name;
   ?>
   <table>
      <tr> 
        <td style="text-align: right;"><B><nobr>
          <?php print $lang->users_login_email; ?>
          :</nobr></B></td>
        <td>
          <input type="text" size="20" name="form[login]">
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><B><nobr>
          <?php print $lang->users_password;?>
          :</nobr></B></td>
        <td> 
          <input type="password" size="20" name="form[password]">
          </td>
          
      </tr>
      </table>
      <input class="btn btn-primary" type="submit" value='<?php print $lang->users_log_in; ?>'>

      </form>
    </div>
    
        </td> 
	</tr>
	<tr>
        <td align="center">
	
	
    <div id="login_form_right">
    
             <br/>
    <?php
  global $_SESSION;
  if (empty($_SESSION['global_login'])) {
     print "$lang->users_register_desc. <br/><a href=/dodaj-nowego style=\"font: bold 11px Tahoma; color: #ff8c00;\">".$lang->users_register."</a>";
  }
print "<br/><br/><br/>";
  ?>
      <?php print $lang->users_forgot_password." <br/><a href=/przypomnij-haslo style=\"font: bold 11px Tahoma; color: #ff8c00;\">".$lang->users_click_here."</a>";?>
    </div>
    
    </td>
      </tr>
      </table>


<br/><br/><br/>
