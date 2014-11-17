<?php
/**
* @version    $Id: mbank_config.html.php,v 1.4 2004/12/20 18:00:39 maroslaw Exp $
* @package    pay
* @subpackage mbank
*/
global $mbank_config;
if($mbank_config->mbank_mode == "product") {
    $checked2='checked';
    $checked3='';
} else {
    $checked3='checked';
    $checked2='';
}
?>


<form action=config.php method=POST name=mbank_config>
<input type=hidden name=item[save] value=1>
<p>

<?php $theme->frame_open($lang->mbank_config['frames1']);?>
<table>

<tr>
<td>
<?php print $lang->mbank_config['email']; ?>
</td>
<td>
<input type=text size=60 name=item[email] value='<?php print @$mbank_config->mbank_email; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['login']; ?>
</td>
<td>
<input type=text size=60 name=item[login] value='<?php print @$mbank_config->mbank_login; ?>'>
</td>
</tr>


<tr>
<td>
<?php print $lang->mbank_config['password']; ?>
</td>
<td>
<input type=text size=60 name=item[password] value='<?php print @$mbank_config->mbank_password; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['mail_host']; ?>
</td>
<td>
<input type=text size=60 name=item[mail_host] value='<?php print @$mbank_config->mbank_mail_host; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['title_email']; ?>
</td>
<td>
<input type=text size=60 name=item[title_email] value='<?php print @$mbank_config->mbank_title_email; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['no_safe']; ?>
</td>
<td>
<input type=text size=60 name=item[no_safe] value='<?php print @$mbank_config->mbank_no_safe; ?>'>
</td>
</tr>

</table>
<?php $theme->frame_close();?>






<?php $theme->frame_open($lang->mbank_config['frames2']);?>
<table>

<tr>
<td>
<?php print $lang->mbank_config['id']; ?>
</td>
<td>
<input type=text size=60 name=item[merchant_id] value='<?php print @$mbank_config->mbank_merchant_id;
?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['pass_gpg']; ?>
</td>
<td>
<input type=text size=60 name=item[pass_gpg] value='<?php print @$mbank_config->mbank_pass_gpg;
?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['info']; ?>
</td>
<td>
<input type=text size=60 name=item[info] value='<?php print @$mbank_config->mbank_info; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['server']; ?>
</td>
<td>
<input type=text size=60 name=item[server] value='<?php print @$mbank_config->mbank_server; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['back_ok']; ?>
</td>
<td>
<input type=text size=60 name=item[back_ok] value='<?php print "http://".$config->www."/".@$mbank_config->mbank_back_ok; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->mbank_config['back_error']; ?>
</td>
<td>
<input type=text size=60 name=item[back_error] value='<?php print "http://".$config->www."/".@$mbank_config->mbank_back_error; ?>'>
</td>
</tr>


<tr>
<td>
<?php print $lang->mbank_config['mode']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->mbank_config['product']; ?></td><td align=right>
<input type=radio name=item[mode] value='product' <?php print $checked2; ?>></td><td width=120 align=right>
<?php print $lang->mbank_config['test']; ?></td><td>
<input type=radio name=item[mode] value='test' <?php print $checked3; ?>>
</td>
</tr>
</table>
</td>
</tr>

</table>
<?php $theme->frame_close();?>

<br>

<center>
   <?php
      $buttons->button($lang->mbank_config['save'],"javascript:document.mbank_config.submit();");
?>
</center>
</from>
