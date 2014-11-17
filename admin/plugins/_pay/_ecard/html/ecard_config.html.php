<?php
global $config;
print "<br>";
$theme->desktop_open("100%"); 

//print "<pre>";
//print_r($config);
//print "</pre>";
if(!empty($ecard_config->ecardActive)) $ecardActive="checked";
if(!empty($ecard_config->ecardStatus)) {
	$ecardStatus="checked";
} else {
	$ecardStatus="";
}
?>
<form action=index.php method=POST name=ecard_config>
<input type=hidden name=item[save] value=1>
<p>
<img src=/themes/base/base_theme/_icons/ecard.png align="right" style="padding-right: 10px">
<?php// $theme->frame_open($lang->ecard_config['frames1']);?>
<table>

<tr>
<td>
<?php print $lang->ecard_config['ecardAccount']; ?>
</td>
<td>
<input type=text size=70 name=item[ecardAccount] value='<?php print @$ecard_config->ecardAccount; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardPassword']; ?>
</td>
<td>
<input type=password size=70 name=item[ecardPassword] value='<?php print @$ecard_config->ecardPassword; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardReturnUrl']; ?>
</td>
<td>
<input type=text size=70 name=item[ecardReturnUrl] value='<?php print "http://".$config->www."/".@$ecard_config->ecardReturnUrl; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardCancelReturnUrl']; ?>
</td>
<td>
<input type=text size=70 name=item[ecardCancelReturnUrl] value='<?php print "http://".$config->www."/".@$ecard_config->ecardCancelReturnUrl; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardServerHash']; ?>
</td>
<td>
<input type=text size=70 name=item[ecardServerHash] value='<?php print @$ecard_config->ecardServerHash; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardServerPay']; ?>
</td>
<td>
<input type=text size=70 name=item[ecardServerPay] value='<?php print @$ecard_config->ecardServerPay; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardAddressCheck']; ?>
</td>
<td>
<input type=text size=70 name=item[ecardAddressCheck] value='<?php print "http://".$config->www."/".@$ecard_config->ecardAddressCheck; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardLang']; ?>
</td>
<td>
<?php
if($ecard_config->ecardLang == 'PL') {
   $selected11="selected";
} else {
   $selected22="selected";
}
?>
<select name=item[ecardLang]>
<OPTION value="PL" <?php print @$selected11; ?>>PL</OPTION>
<OPTION value="EN" <?php print @$selected22; ?>>EN</OPTION>
</select>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardPayType']; ?>
</td>
<td>
<?php
if($ecard_config->ecardPayType == 'ALL') {
   $selected1="selected";
} elseif($ecard_config->ecardPayType == 'CARD') {
   $selected2="selected";
} else {
   $selected3="selected";
}
?>
<select name=item[ecardPayType]>
<OPTION value="ALL" <?php print @$selected1; ?>>ALL</OPTION>
<OPTION value="CARD" <?php print @$selected2; ?>>CARD</OPTION>
<OPTION value="TRANSFER" <?php print @$selected3; ?>>TRANSFER</OPTION>
/select>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardActive']; ?>
</td>
<td>
<input type=checkbox name=item[ecardActive] value='1' <?php print @$ecardActive; ?>>
</td>
</tr>

<tr>
<td>
<?php print $lang->ecard_config['ecardStatus']; ?>
</td>
<td>
<input type=checkbox name=item[ecardStatus] value='1' <?php print @$ecardStatus; ?>>
</td>
</tr>
</table>
<?php// $theme->frame_close();?>
<center>
   <?php
      $buttons->button($lang->ecard_config['save'],"javascript:document.ecard_config.submit();");
?>
</center>
</from>

<?php $theme->desktop_close(); ?>
