<?php
/**
 * Konfiguracja modulu interia pasaz.
 *
 * @author  rdiak@sote.pl
 * @version $Id: interia_config.html.php,v 1.3 2005/04/04 09:55:46 scalak Exp $
 *
* @package    pasaz.interia.pl
 */
if($interia_config->interia_load == "product") {
    $checked2='checked';
    $checked3='';
} else {
    $checked3='checked';
    $checked2='';
}
?>

<form action=config.php method=POST name=interia_config>
<input type=hidden name=item[save] value=1>
<p>

<?php $theme->frame_open($lang->interia_config['options']);?>
<table>
<tr><td>
<?php print $lang->interia_config['id']; ?>
</td>
<td>
<input type=text size=40 name=item[id] value='<?php print $interia_config->interia_shop_id; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->interia_config['load']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->interia_config['product']; ?></td><td>
<input type=radio name=item[load] value='product' <?php print $checked2; ?>></td><td width=120>
<?php print $lang->interia_config['test']; ?></td><td>
<input type=radio name=item[load] value='test' <?php print $checked3; ?>>
</td>
</tr>
</table>
</td>
</tr>

</table>
<?php $theme->frame_close();?>

<br>
 

<table>
<tr>
<td>
<?php $theme->frame_open($lang->interia_config['network']);?>
<table>

<tr>
<td>
<?php print $lang->interia_config['pass']; ?>
</td>
<td>
<input type=password size=25 name=item[password] value='<?php print $interia_config->interia_password; ?>'>

</td>
</tr>

<tr>
<td>
<?php print $lang->interia_config['partner_name']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=25 name=item[partner_name] value='<?php print $interia_config->interia_partner_name; ?>' readonly >
</td>
</tr>


<tr>
<td>
<?php print $lang->interia_config['server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size=40 name=item[server] value='<?php print $interia_config->interia_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->interia_config['test_server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size=40 name=item[test_server] value='<?php print @$interia_config->interia_test_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->interia_config['get_category']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[rpc] value='<?php print $interia_config->interia_rpc; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->interia_config['biling']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[message] value='<?php print $interia_config->interia_message; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->interia_config['transaction']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[transaction] value='<?php print $interia_config->interia_transaction; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->interia_config['port']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[port] value='<?php print $interia_config->interia_port; ?>' readonly>
</td>
</tr>


</table>
<?php $theme->frame_close();?>
</td>
<td valign=top>
<?php $theme->frame_open($lang->interia_config['category']);?>
<?php
global $database;
$select=@$interia_config->interia_category;
$select=$database->sql_select_multiple("interia_main_category","category[]","name","name","","","","10",$select);
print $select;
?>

<?php $theme->frame_close();?>
<center><a href='/plugins/_pasaz.interia.pl/config.php'><u><?php print $lang->interia_config['back']; ?></u></a></center>
</td>
</tr>
</table>

<center>
   <?php
      $buttons->button($lang->interia_config['save'],"javascript:document.interia_config.submit();");
?>
</center>
</from>
