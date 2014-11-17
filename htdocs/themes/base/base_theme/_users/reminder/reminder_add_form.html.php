<?php
/**
* @version    $Id: reminder_add_form.html.php,v 1.2 2004/12/20 18:02:34 maroslaw Exp $
* @package    users
*/
?>
<br /> 
<center>
  <form method="post" action="<?php print $this->action;?>">
    <input type="hidden" name="update" value="true">
    <input type="hidden" name="reminder[id]" value="<?php $this->form_val('id');?>">
    <input type="hidden" name="reminder[id_users]" value="<?php print $_SESSION['global_id_user'];?>">
    <table border="0" cellspacing="0" cellpadding="0" align="center">
      <tr> 
        <td align="left" valign="top"><b>Miesi±c:</b><br /><?php $this->form_error('month');?></td>
        <td align="left" valign="middle">&nbsp;&nbsp;&nbsp;</td>
        <td align="left" valign="top"><?php $this->user_reminder->selectMonth();?></td>
      </tr>
      <tr> 
        <td align="left" valign="top"><b>Dzieñ:</b><br /><?php $this->form_error('day');?></td>
        <td align="left" valign="middle">&nbsp;&nbsp;&nbsp;</td>
        <td align="left" valign="top"><?php $this->user_reminder->selectDay();?></td>
      </tr>
      <tr> 
        <td align="left" valign="top"><b>Okazja:</b><br /><?php $this->form_error('occasion');?></td>
        <td align="left" valign="middle">&nbsp;&nbsp;&nbsp;</td>
        <td align="left" valign="top"><?php $this->user_reminder->selectOccasion();?></td>
      </tr>
      <tr> 
        <td align="left" valign="top"><b>Imie osoby / Wydarzenie:</b><br /><?php $this->form_error('event');?></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><input type="text" name="reminder[event]" value="<?php $this->form_val('event');?>"></td>
      </tr>
      <tr> 
        <td align="left" valign="top"><b>Powiadomienie:</b><br /><?php $this->form_error('advise');?></td>
        <td align="left" valign="middle">&nbsp;&nbsp;&nbsp;</td>
        <td align="left" valign="top"><?php $this->user_reminder->selectAdvise();?></td>
      </tr>
      <tr> 
        <td align="left" valign="top"><b>Wy¶lij e-mail z powiadamieniem:</b></td>
        <td align="left" valign="top">&nbsp;&nbsp;&nbsp;</td>
        <td align="left" valign="top"> 
          <table border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td><?php $this->user_reminder->checkBox("handling1");?></td>
              <td>2-3 dni przed<?php $this->form_error('handling1');?></td>
            </tr>
            <tr> 
              <td><?php $this->user_reminder->checkBox("handling2");?></td>
              <td>tydzieñ przed<?php $this->form_error('handling2');?></td>
            </tr>
            <tr> 
              <td><?php $this->user_reminder->checkBox("handling3");?></td>
              <td>2 tygonie przed<?php $this->form_error('handling3');?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td align="left" valign="top">
          <input type="submit" name="Submit" value="Dodaj">
        </td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
  </form>
</center>
