<?php
global $config;

//print "<pre>";
//print_r($config);
//print "</pre>";
if(!empty($paypal_config->payPalActive)) $payPalActive="checked";
if(!empty($paypal_config->payPalStatus)) $payPalStatus="checked";
?>


<form action=index.php method=POST name=paypal_config>
<input type=hidden name=item[save] value=1>
<p>
<img src=/themes/base/base_theme/_img/paypal_logo.png align="right"><br />

<?php $theme->frame_open($lang->paypal_config['frames1']);?>
<table>

<tr>
<td>
<?php print $lang->paypal_config['payPalAccount']; ?>
</td>
<td>
<input type=text size=70 name=item[payPalAccount] value='<?php print @$paypal_config->payPalAccount; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->paypal_config['payPalCompany']; ?>
</td>
<td>
<input type=text size=70 name=item[payPalCompany] value='<?php print @$paypal_config->payPalCompany; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->paypal_config['payPalReturnUrl']; ?>
</td>
<td>
<input type=text size=70 name=item[payPalReturnUrl] value='<?php print "http://".$config->www."/".@$paypal_config->payPalReturnUrl; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->paypal_config['payPalCancelReturnUrl']; ?>
</td>
<td>
<input type=text size=70 name=item[payPalCancelReturnUrl] value='<?php print "http://".$config->www."/".@$paypal_config->payPalCancelReturnUrl; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->paypal_config['payPalServerUrl']; ?>
</td>
<td>
<input type=text size=70 name=item[payPalServerUrl] value='<?php print @$paypal_config->payPalServerUrl; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->paypal_config['payPalServerTestUrl']; ?>
</td>
<td>
<input type=text size=70 name=item[payPalServerTestUrl] value='<?php print @$paypal_config->payPalServerTestUrl; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->paypal_config['payPalActive']; ?>
</td>
<td>
<input type=checkbox name=item[payPalActive] value='1' <?php print @$payPalActive; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->paypal_config['payPalStatus']; ?>
</td>
<td>
<input type=checkbox name=item[payPalStatus] value='1' <?php print @$payPalStatus; ?>'>
</td>
</tr>

</table>
<?php $theme->frame_close();?>

<br>

<center>
   <?php
      $buttons->button($lang->paypal_config['save'],"javascript:document.paypal_config.submit();");
?>
</center>
</from>


