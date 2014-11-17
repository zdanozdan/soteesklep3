<?php
/**
 * Strona konfiguracyjna modu³u ceneo pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: ceneo_config.html.php,v 1.4 2006/04/20 09:09:51 scalak Exp $
 *
* @package    pasaz.ceneo.pl
 */


if($ceneo_config->ceneo_load == "product") {
    $checked2='checked';
    $checked3='';
} else {
    $checked3='checked';
    $checked2='';
} 
?>

<form action=config.php method=POST name=ceneo_config>
<input type=hidden name=item[save] value=1>
<p>

<table>
<tr>
<td>

<?php $theme->frame_open($lang->ceneo_config['options']);?>
<table>
<tr><td>
<?php print $lang->ceneo_config['id']; ?>
</td>
<td>
<input type=text size=45 name=item[id] value='<?php print $ceneo_config->ceneo_shop_id; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->ceneo_config['load']; ?>
</td>
<td>
<table cellspacing="5"><tr><td width=100>
<?php print $lang->ceneo_config['product']; ?></td><td>
<input type=radio name=item[load] value='product' <?php print $checked2; ?>></td><td>
<?php print $lang->ceneo_config['test']; ?></td><td>
<input type=radio name=item[load] value='test' <?php print $checked3; ?>>
</td>
</tr>
</table>
</td>
</tr>



</table>
<?php $theme->frame_close();?>
</td>
</tr>
</table>

<br>

<table>
<tr>
<td>
<?php $theme->frame_open($lang->ceneo_config['network']);?>
<table>

<tr>
<td>
<?php print $lang->ceneo_config['login']; ?>
</td>
<td>
<input type=text size=25 name=item[login] value='<?php print $ceneo_config->ceneo_login; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->ceneo_config['pass']; ?>
</td>
<td>
<input type=password size=25 name=item[password] value='<?php print $ceneo_config->ceneo_password; ?>'>
</td>
</tr>

<tr>
<td>
<?php print $lang->ceneo_config['partner_name']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size=25 name=item[partner_name] value='<?php print $ceneo_config->ceneo_partner_name; ?>' readonly >
</td>
</tr>

<tr>
<td>
<?php print $lang->ceneo_config['server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[server] value='<?php print $ceneo_config->ceneo_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->ceneo_config['test_server']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[test_server] value='<?php print @$ceneo_config->ceneo_test_server; ?>' readonly>
</td>
</tr>

<tr>
<td>
<?php print $lang->ceneo_config['biling']; ?>
</td>
<td>
<input type=text  style='background-color: #dddddd' size="80" name=item[message] value='<?php print $ceneo_config->ceneo_message; ?>' readonly>
</td>
</tr>


<tr>
<td>
<?php print $lang->ceneo_config['port']; ?>
</td>
<td>
<input type=text style='background-color: #dddddd' size="80" name=item[port] value='<?php print $ceneo_config->ceneo_port; ?>' readonly>
</td>
</tr>

</table>
<?php $theme->frame_close();?>
</td>
<td valign=top>
<?php $theme->frame_open($lang->ceneo_config['category']);

global $database;
$select=@$ceneo_config->ceneo_category;
$select=$database->sql_select_multiple("ceneo_main_category","category[]","name","name","","","","5",$select);
print $select;

$theme->frame_close();?>
<center><a href='/plugins/_pasaz.ceneo.pl/config.php'><u><?php print $lang->ceneo_config['back']; ?></u></a></center>
</td>
</tr>
</table>

<center>
   <?php
      $buttons->button($lang->ceneo_config['save'],"javascript:document.ceneo_config.submit();");
?>
</center>
</from>
