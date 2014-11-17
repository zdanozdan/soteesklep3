<?php
/**
 * Strona konfiguracyjna modu³u allegro.
 *
 * @author  krzysk@sote.pl
 * @version $Id: allegro_config.html.php,v 1.5 2006/04/12 11:45:27 scalak Exp $
 *
* @package    allegro
 */
if($allegro_config->allegro_mode == "true") {
    $checked='checked';
    $checked1='';
} else {
    $checked1='checked';
    $checked='';
} 

?>

<form action=config.php method=POST name=allegro_config>
<input type=hidden name=item[save] value=1>

<table border=0 width="65%" cellpadding="3" cellspacing="3" align="center">
<tr>
<td colspan="2" width="60%" align="center"><?php print "<img src=";$theme->img("_img/allegro_logo.gif");print ">\n";?>
</td>
</tr>
<tr>
<td width="70%" align="center" valign="top"><?php $theme->frame_open($lang->allegro_config['options']);?>
<table border="0" cellpadding="3" cellspacing="0">
		<tr>
		<td width="100"><?php print $lang->allegro_config['login'] ;?>:</td>
		<td><input type=text size=20 name=item[login] value='<?php print @$allegro_config->allegro_login; ?>'></td>
		<td width="100"><?php print $lang->allegro_config['login_test'] ;?>:</td>
		<td><input type=text size=20 name=item[login_test] value='<?php print @$allegro_config->allegro_login_test; ?>'></td>
		</tr>
		<tr>
		<td><?php print $lang->allegro_config['password'] ;?>:</td>
		<td><input type=password size=20 name=item[password] value='<?php print @$allegro_config->allegro_password; ?>'></td>
		<td><?php print $lang->allegro_config['password_test'] ;?>:</td>
		<td><input type=password size=20 name=item[password_test] value='<?php print @$allegro_config->allegro_password_test; ?>'></td>
		</tr>
		<tr>
		<td><nobr><?php print $lang->allegro_config['web_api_key'] ;?></nobr>:</td>
		<td><input type=text size=20 name=item[web_api_key] value='<?php print @$allegro_config->allegro_web_api_key; ?>'></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td><?php print $lang->allegro_config['country_code'] ;?></td>
		<td><input type=text size=20 name=item[country_code] value='<?php print @$allegro_config->allegro_country_code; ?>'></td>
		<td><?php print $lang->allegro_config['country_code_test'] ;?></td>
		<td><input type=text size=20 name=item[country_code_test] value='<?php print @$allegro_config->allegro_country_code_test; ?>'></td>
		</tr>
		<tr>
		<td><?php print $lang->allegro_config['version'] ;?></td>
		<td><input type=text size=20 name=item[version] value='<?php print @$allegro_config->allegro_version; ?>'></td>
		<td><?php print $lang->allegro_config['version_test'] ;?></td>
		<td><input type=text size=20 name=item[version_test] value='<?php print @$allegro_config->allegro_version_test; ?>'></td>
		</tr>

		<tr>
		<td colspan="2"><?php print $lang->allegro_config['city'] ;?></td>
		<td colspan="2"><input type=text size=50 name=item[city] value='<?php print @$allegro_config->allegro_city; ?>'></td>
		</tr>

		<tr>
		<td colspan="2"><?php print $lang->allegro_config['state_select'] ;?></td>
		<td colspan="2">
        <select name=item[state_select]>
		<?php
		foreach($allegro_config->allegro_states as $key=>$value) {
		  if($key == $allegro_config->allegro_state_select) {
		      print "<option value=".$key." selected>".$value."</option>";
		  } else {
		      print "<option value=".$key.">".$value."</option>";
		  }
		}
		
		?>
		</select>
		</td>
		</tr>
		<tr>
		<td colspan="2"><?php print $lang->allegro_config['server'] ;?></td>
		<td colspan="2"><input type=text size=50 name=item[server] value='<?php print @$allegro_config->allegro_server; ?>'></td>
		</tr>

		<tr>
		<td colspan="2"><?php print $lang->allegro_config['mode'] ;?></td>
		<td colspan="2">
		<?php print $lang->allegro_config['product']; ?>
		<input type=radio name=item[mode] value='true' <?php print @$checked; ?>>
        <?php print $lang->allegro_config['test']; ?>
        <input type=radio name=item[mode] value='false' <?php print @$checked1; ?>>
		</td>
		</tr>
		
		</table>
<?php $theme->frame_close();?>
</td>
<td width="20%" colspan=2 valign="top"><?php $theme->frame_open($lang->allegro_config['category']);?><table border="1" cellpadding="3" cellspacing="0">
		<tr>
		<td align="center">
<?php

//wlaczyc gdy bedzie baza - nietestowane
global $database;
$select=@$allegro_config->allegro_category;
$data=$database->sql_select_multiple("allegro_cat","category[]","cat_id","cat_name","","cat_parent=0","","8",$select);
print $data;
?>
<!-- dla testow -->
		</td>
		</tr>
	</table>
<?php $theme->frame_close();?>

</td>
</tr>
</table>
<center>
   <?php
      $buttons->button($lang->allegro_config['save'],"javascript:document.allegro_config.submit();");
?>
</center>
</from>
