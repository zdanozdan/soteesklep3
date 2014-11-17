<?php
/**
* @version    $Id: inteligo_config.html.php,v 1.5 2004/12/20 18:00:38 maroslaw Exp $
* @package    pay
* @subpackage inteligo
*/
global $inteligo_config;
if(@$inteligo_config->inteligo_mode == "product") {
	$checked2='checked';
	$checked3='';
} else {
	$checked3='checked';
	$checked2='';
}
if(@$inteligo_config->inteligo_coding == "none") {
	$checked_1='checked';
} elseif(@$inteligo_config->inteligo_coding == "md5")  {
	$checked_2='checked';
} elseif(@$inteligo_config->inteligo_coding == "sha1")  {
	$checked_3='checked';
} else {
	$checked_2='checked';
}

if(@$inteligo_config->inteligo_lock == "zero") {
	$checked4='checked';
	$checked5='';
} else {
	$checked5='checked';
	$checked4='';
}

if(@$inteligo_config->inteligo_number == "01") {
	$checked_num_1='checked';
} elseif(@$inteligo_config->inteligo_number == "02")  {
	$checked_num_2='checked';
} elseif(@$inteligo_config->inteligo_number == "03")  {
	$checked_num_3='checked';
} else {
	$checked_num_1='checked';
}



?>


<form action=config.php method=POST name=inteligo_config>
<input type=hidden name=item[save] value=1>
<p>

<?php $theme->frame_open($lang->inteligo_config['frames1']);?>
<table>
<tr><td>
<?php print $lang->inteligo_config['id']; ?>
</td>
<td>
<input type=text size=60 name=item[merchant_id] value='<?php print @$inteligo_config->inteligo_merchant_id;
?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['email']; ?>
</td>
<td>
<input type=text size=60 name=item[email] value='<?php print @$inteligo_config->inteligo_email; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['pay_method']; ?>
</td>
<td>
<input type=text size=60 name=item[pay_method] value='<?php print @$inteligo_config->inteligo_pay_method; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['currency']; ?>
</td>
<td>
<input type=text size=60 name=item[currency] value='<?php print @$inteligo_config->inteligo_currency; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['info']; ?>
</td>
<td>
<input type=text size=60 name=item[info] value='<?php print @$inteligo_config->inteligo_info; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['server']; ?>
</td>
<td>
<input type=text size=60 name=item[server] value='<?php print @$inteligo_config->inteligo_server; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['key']; ?>
</td>
<td>
<input type=text size=60 name=item[key] value='<?php print @$inteligo_config->inteligo_key; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['back_ok']; ?>
</td>
<td>
<input type=text size=60 name=item[back_ok] value='<?php print "http://".$config->www."/".@$inteligo_config->inteligo_back_ok; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['back_error']; ?>
</td>
<td>
<input type=text size=60 name=item[back_error] value='<?php print "http://".$config->www."/".@$inteligo_config->inteligo_back_error; ?>'>
</td>
</tr>


<tr>
<td>
<?php print $lang->inteligo_config['mode']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->inteligo_config['product']; ?></td><td align=right>
<input type=radio name=item[mode] value='product' <?php print $checked2; ?>></td><td width=120 align=right>
<?php print $lang->inteligo_config['test']; ?></td><td>
<input type=radio name=item[mode] value='test' <?php print $checked3; ?>>
</td>
</tr>
</table>
</td>
</tr>


<tr>
<td>
<?php print $lang->inteligo_config['lock']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->inteligo_config['zero']; ?></td><td align=right>
<input type=radio name=item[lock] value='zero' <?php print $checked4; ?>></td><td width=120 align=right>
<?php print $lang->inteligo_config['files']; ?></td><td>
<input type=radio name=item[lock] value='files' <?php print $checked5; ?>>
</td>
</tr>
</table>
</td>
</tr>



<tr>
<td>
<?php print $lang->inteligo_config['coding']; ?>
</td>
<td>
<table><tr><td width=100 align=right>
<?php print $lang->inteligo_config['none']; ?></td><td>
<input type=radio name=item[coding] value='none' <?php print @$checked_1; ?>></td><td width=120 align=right>
<?php print $lang->inteligo_config['md5']; ?></td><td>
<input type=radio name=item[coding] value='md5' <?php print @$checked_2; ?>></td><td width=120 align=right>
<?php print $lang->inteligo_config['sha1']; ?></td><td>
<input type=radio name=item[coding] value='sha1' <?php print @$checked_3; ?>>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td>
<?php print $lang->inteligo_config['number']; ?>
</td>
<td>
<table><tr><td width=100 align=right>
<?php print $lang->inteligo_config['one']; ?></td><td>
<input type=radio name=item[number] value='01' <?php print @$checked_num_1; ?>></td><td width=120 align=right>
<?php print $lang->inteligo_config['two']; ?></td><td>
<input type=radio name=item[number] value='02' <?php print @$checked_num_2; ?>></td><td width=120 align=right>
<?php print $lang->inteligo_config['three']; ?></td><td>
<input type=radio name=item[number] value='03' <?php print @$checked_num_3; ?>>
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
   $buttons->button($lang->inteligo_config['save'],"javascript:document.inteligo_config.submit();");
?>
</center>
</from>
