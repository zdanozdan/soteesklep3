<?php
/**
 * Strona konfiguracyjna modu³u delivery pasa¿.
 *
 * @author  rdiak@sote.pl
 * @version $Id: delivery_config.html.php,v 2.7 2005/02/08 12:55:36 scalak Exp $
 *
* @package    pasaz.delivery.pl
 */
?>

<form action=config.php method=POST name=delivery_config id="delivery_config">
<input type=hidden name=item[save] value=1>
<p>

<?php $theme->frame_open($lang->delivery_config['country']);?>
<script>
function toggleAll(sender) {
    check_yes_no = sender.checked;
    for(i = 0; i < document.forms["delivery_config"].elements.length; i++) {
        if((document.forms["delivery_config"].elements[i].type == 'checkbox') && (document.forms["delivery_config"].elements[i].name != "toggle_all"))
            document.forms["delivery_config"].elements[i].checked = check_yes_no;
    }
}
</script>


<table>
<td>
<?php
global $lang;
global $config;

$i=0;
$count=count($lang->country);
print "<table align=center>\n";
print "<tr><td align=center>\n";
echo "<b>".$lang->delivery_config['toggle_all']."</b>"; 
print "<input type=\"checkbox\" name=\"toggle_all\" id=\"toggle_all\" onclick=\"toggleAll(this)\" checked>";
print "</td></tr>\n";
print "</table>\n";
print "<table>\n";
foreach ($lang->country as $key=>$value) {
	$checked='';
	if(!empty($config->country_select)) {
		if(array_key_exists($key, $config->country_select)) {
			$checked='checked';
		}
	} else {
		$checked='checked';
	}	
	
	if($i == 0) print "<tr>";	
	print "<td><input type=checkbox name=item1[".$key."] value=1 ".$checked.">".$value."</td>\n";
	$i++;
	if($i==3) {
		print "</tr>";
		$i=0;
	}	
}
print "</table>\n";
?>

</td>
</tr>
</table>
<table align=center>
<tr><td align=center>
<?php echo "<b>".$lang->delivery_config['toggle_all']."</b>"; ?>
<input type="checkbox" name="toggle_all" id="toggle_all1" onclick="toggleAll(this)" checked>
</td></tr>
</table>
<?php $theme->frame_close();?>

<center>
   <?php
      $buttons->button($lang->delivery_config['save'],"javascript:document.delivery_config.submit();");
?>
</center>
</from>
