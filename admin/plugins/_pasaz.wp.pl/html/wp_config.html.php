<?php
/**
 * Konfiguracja modulu wp pasaz.
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_config.html.php,v 1.5 2004/12/20 18:00:35 maroslaw Exp $
 *
* @package    pasaz.wp.pl
 */

if($wp_config->wp_mode == "true") {
    $checked='checked';
    $checked1='';
} else {
    $checked1='checked';
    $checked='';
} 

if($wp_config->wp_load == "product") {
    $checked2='checked';
    $checked3='';
} else {
    $checked3='checked';
    $checked2='';
} 
?>

<form action=config.php method=POST name=wp_config>
<input type=hidden name=item[save] value=1>
<p>

<?php $theme->frame_open($lang->wp_config['options']);?>
<table>
<tr><td>
<?php print $lang->wp_config['id']; ?>
</td>
<td>
<input type=text size=40 name=item[id] value='<?php print $wp_config->wp_shop_id; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['mode']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->wp_config['full']; ?> </td><td>
<input type=radio name=item[mode] value='true' <?php print $checked; ?>> </td><td width=120>
<?php print $lang->wp_config['update']; ?></td><td>
<input type=radio name=item[mode] value='false' <?php print $checked1; ?>>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<?php print $lang->wp_config['load']; ?>
</td>
<td>
<table><tr><td width=100>
<?php print $lang->wp_config['product']; ?></td><td>
<input type=radio name=item[load] value='product' <?php print $checked2; ?>></td><td width=120>
<?php print $lang->wp_config['test']; ?></td><td>
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
<?php $theme->frame_open($lang->wp_config['network']);?>
<table>
<tr>
<td>
<?php print $lang->wp_config['login']; ?>
</td>
<td>
<input type=text size=25 name=item[login] value='<?php print $wp_config->wp_login; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['pass']; ?>
</td>
<td>
<input type=password size=25 name=item[password] value='<?php print $wp_config->wp_password; ?>'>

</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['partner_name']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=25 name=item[partner_name] value='<?php print $wp_config->wp_partner_name; ?>' readonly >
</td>
</tr>


<tr>
<td>
<?php print $lang->wp_config['server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size=40 name=item[server] value='<?php print $wp_config->wp_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['test_server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size=40 name=item[test_server] value='<?php print @$wp_config->wp_test_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['get_category']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[rpc] value='<?php print $wp_config->wp_rpc; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['biling']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[message] value='<?php print $wp_config->wp_message; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['transaction']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[transaction] value='<?php print $wp_config->wp_transaction; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['port']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=40 name=item[port] value='<?php print $wp_config->wp_port; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->wp_config['confirm']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=55 name=item[confirm_trans] value='<?php print "http://".$config->www."/".@$wp_config->wp_confirm_trans; ?>' readonly>
</td>
</tr>

</table>
<?php $theme->frame_close();?>
</td>
<td valign=top>
<?php $theme->frame_open($lang->wp_config['category']);?>
<?php
global $database;
$select=@$wp_config->wp_category;
$select=$database->sql_select_multiple("wp_main_tree","category[]","name","name","","","","10",$select);
print $select;
?>

<?php $theme->frame_close();?>
<center><a href='/plugins/_pasaz.wp.pl/config.php'><u><?php print $lang->wp_config['back']; ?></u></a></center>
</td>
</tr>
</table>

<center>
   <?php
      $buttons->button($lang->wp_config['save'],"javascript:document.wp_config.submit();");
?>
</center>
</from>
