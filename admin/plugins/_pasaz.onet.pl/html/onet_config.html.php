<?php
/**
 * Strona konfiguracyjna modu³u onet pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_config.html.php,v 1.16 2004/12/20 18:00:30 maroslaw Exp $
 *
* @package    pasaz.onet.pl
 */

if($onet_config->onet_mode == "true") {
    $checked='checked';
    $checked1='';
} else {
    $checked1='checked';
    $checked='';
} 

if($onet_config->onet_load == "product") {
    $checked2='checked';
    $checked3='';
} else {
    $checked3='checked';
    $checked2='';
} 
?>

<form action=config.php method=POST name=onet_config>
<input type=hidden name=item[save] value=1>
<p>

<table>
<tr>
<td>

<?php $theme->frame_open($lang->onet_config['options']);?>
<table>
<tr><td>
<?php print $lang->onet_config['id']; ?>
</td>
<td>
<input type=text size=45 name=item[id] value='<?php print $onet_config->onet_shop_id; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['mode']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->onet_config['full']; ?> </td><td>
<input type=radio name=item[mode] value='true' <?php print $checked; ?>> </td><td width=120>
<?php print $lang->onet_config['update']; ?></td><td>
<input type=radio name=item[mode] value='false' <?php print $checked1; ?>>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<?php print $lang->onet_config['load']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->onet_config['product']; ?></td><td>
<input type=radio name=item[load] value='product' <?php print $checked2; ?>></td><td width=120>
<?php print $lang->onet_config['test']; ?></td><td>
<input type=radio name=item[load] value='test' <?php print $checked3; ?>>
</td>
</tr>
</table>
</td>
</tr>



</table>
<?php $theme->frame_close();?>
</td>
<td>
<?php $theme->frame_open($lang->onet_config['category']);?>
<?php
global $database;
$select=@$onet_config->onet_category;
$select=$database->sql_select_multiple("onet_main_category","category[]","name","name","","","","5",$select);
print $select;
?>

<?php $theme->frame_close();?>
<center><a href='/plugins/_pasaz.onet.pl/config.php'><u><?php print $lang->onet_config['back']; ?></u></a></center>


</td>
</tr>
</table>

<br>
 


<?php $theme->frame_open($lang->onet_config['network']);?>
<table>
<tr>
<td>
<?php print $lang->onet_config['login']; ?>
</td>
<td>
<input type=text size=25 name=item[login] value='<?php print $onet_config->onet_login; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['pass']; ?>
</td>
<td>
<input type=password size=25 name=item[password] value='<?php print $onet_config->onet_password; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['partner_name']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=25 name=item[partner_name] value='<?php print $onet_config->onet_partner_name; ?>' readonly >
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[server] value='<?php print $onet_config->onet_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['test_server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[test_server] value='<?php print @$onet_config->onet_test_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['get_category']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[rpc] value='<?php print $onet_config->onet_rpc; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['biling']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[message] value='<?php print $onet_config->onet_message; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['transaction']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[transaction] value='<?php print $onet_config->onet_transaction; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['port']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size="80" name=item[port] value='<?php print $onet_config->onet_port; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->onet_config['confirm']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size="80" name=item[confirm_trans] value='<?php print "http://".$config->www."/".@$onet_config->onet_confirm_trans; ?>' readonly>
</td>
</tr>

</table>
<?php $theme->frame_close();?>

<center>
   <?php
      $buttons->button($lang->onet_config['save'],"javascript:document.onet_config.submit();");
?>
</center>
</from>
