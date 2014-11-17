<?php
/**
* Formularz konfiguracji newslettera
*
* @author  rdiak@sote.pl
* @version $Id: newsletter_config_L0.html.php,v 2.4 2006/07/17 12:20:36 lukasz Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/
global $lang,$config;

if ($choose_lang=='4'){
 $selected4="selected";   
}elseif ($choose_lang=='3'){
 $selected3="selected";   
}elseif ($choose_lang=='2'){
 $selected2="selected";   
}elseif ($choose_lang=='1'){
 $selected1="selected";   
}
else{
 $selected0="selected";
}

?>
<form name='MyForm5' method='post' action='config.php'>
<?php if ($config->nccp=="0x1388"){ ?>
<select onchange='javascript:document.MyForm5.submit();' name='item[choose_lang]'>
<option value='0' <?php print @$selected0;?>><?php print $config->langs_names['0'];?></option>
<option value='1' <?php print @$selected1;?>><?php print $config->langs_names['1'];?></option>
<option value='2' <?php print @$selected2;?>><?php print $config->langs_names['2'];?></option>
<option value='3' <?php print @$selected3;?>><?php print $config->langs_names['3'];?></option>
<option value='4' <?php print @$selected4;?>><?php print $config->langs_names['4'];?></option>
</select></form>
<?php } ?>
<form action=config.php method=POST>
<p>

<table width=95% align=center border="0">
<tr>
  <td valign=top width=50%>
    <?php $theme->frame_open($lang->newsletter_config['options']);?>
    <table>
    <tr>
      <td>
        <?php print $lang->newsletter_parametres['sender'];?>
      </td>
      <td>
        <input type=text size=25 name=item[sender] value='<?php print $config_newsletter->newsletter_sender?>'>
      </td>
    </tr>
    <tr>
      <td>
        <?php print $lang->newsletter_parametres['default_group'];?>
      </td>
      <td>
        <input type=text size=5 name=item[group] value='<?php print $config_newsletter->newsletter_group?>'> 
      </td>
    </tr>
    <tr>
      <td>
        <?php print $lang->newsletter_parametres['head'];?>
      </td>
      <td>
        <textarea name=item[head] row=2 cols=25><?php print $config_newsletter->newsletter_head?></textarea>
      </td>
    </tr>
    </table>  
    <?php $theme->frame_close();?>
  
  </td>

<td width="50%" valign="top">
<?php $theme->frame_open($lang->newsletter_config['options']);?>
<table>
<tr>
<td><?php print $lang->newsletter_parametres['foot_delete'];?></td>
</tr>
<tr>
<td><textarea name=item[foot] row=3 cols=40><?php print @$config_newsletter->newsletter_foot?></textarea></td>
</tr>
</table>
<?php $theme->frame_close();?>
</td>
</tr>
</table>

<table width=95% align=center>
<tr>
  <td valign=top width=50%>
    <?php $theme->frame_open($lang->newsletter_config['info']);?>
    <?php print $lang->newsletter_parametres['info_add'];?><br>
    <textarea name=item[info_add] row=3 cols=40><?php print $config_newsletter->newsletter_info_add?></textarea><br><br>
    <?php print $lang->newsletter_parametres['info_del'];?><br>
    <textarea name=item[info_del] row=3 cols=40><?php print $config_newsletter->newsletter_info_del?></textarea><br>
    <?php $theme->frame_close();?>

  </td>
  <td valign=top width=50%>
    <?php $theme->frame_open($lang->newsletter_config['info_link']);?>
    <?php print $lang->newsletter_parametres['foot_add'];?><br>
<textarea name=item[foot_add] row=3 cols=40><?php print $config_newsletter->newsletter_foot_add?></textarea><br><br>
    <?php print $lang->newsletter_parametres['foot_del'];?><br>
    <textarea name=item[foot_del] row=3 cols=40><?php print $config_newsletter->newsletter_foot_del?></textarea><br>
    <?php $theme->frame_close();?>
  </td>
</tr>
</table>

<center><input type=submit name=item[save] value="<?php print $lang->save;?>"></center>
</from>
