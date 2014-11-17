<?php
/**
* @version    $Id: main_mail_form.html.php,v 1.2 2004/12/20 18:01:37 maroslaw Exp $
* @package    contact
*/
?>
<style type="text/css">
body {
    margin: 8px 8px;
}
.input_name {
    text-align: right;
    vertical-align: top;
    padding: 2px 8px;
}
.input { 
    text-align: left;
    vertical-align: top;
    padding: 2px 8px;
}
.input input.field {
    padding: 0px 4px;
    font-size: 11px;
    width: 200px;    
}
.mail{
    border-style: solid;
	border-top-width: 1px; 
	border-right-width: 1px; 
	border-bottom-width: 1px; 
	border-left-width: 1px;
    border-color: #cccccc;
    padding: 8px 8px;    
}
caption {
    padding: 8px;
    font-size: 13px;
    font-weight: bold;
}
</style>
<table class="mail" width="360" border="0" cellspacing="0" cellpadding="0" align="center">
  <caption><?php print $lang->mail_form_elements['header'];?></caption>
  <tbody>
  <tr> 
    <td align="center"> 
      <form name="form1" method="post" action="">
      <input type="hidden" name="send_mail" value="1">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td class="input_name"><?php print $lang->mail_form_names['email'];?></td>
            <td class="input"> 
              <input class="field" type="text" name="form[email]" value="<?php $theme->form_val('email');?>"><br />
              <?php $theme->form_error('email');?>
            </td>
          </tr>
          <tr> 
            <td class="input_name"><?php print $lang->mail_form_names['subject'];?></td>
            <td class="input"> 
              <input class="field" type="text" name="form[subject]" value="<?php $theme->form_val('subject');?>"><br />
              <?php $theme->form_error('subject');?>
            </td>
          </tr>
          <tr> 
            <td class="input_name"><?php print $lang->mail_form_names['content'];?></td>
            <td class="input"> 
              <textarea name="form[content]" cols="40" rows="10"><?php $theme->form_val('content');?></textarea><br />
              <?php $theme->form_error('content');?>
            </td>
          </tr>
          <tr>
            <td class="input_name">&nbsp;</td>
            <td class="input">
              <input type="submit" name="Submit" value="<?php print $lang->mail_form_elements['send_button'];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  </tbody>
</table>
