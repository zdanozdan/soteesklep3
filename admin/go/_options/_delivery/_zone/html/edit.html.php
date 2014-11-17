<?php
/**
* Szablon prezentujacy dane poszczegolnej waluty.
*
* 
* @version $Id: edit.html.php,v 1.14 2005/04/15 13:33:28 scalak Exp $
* @package currency
* 
*/
?>

<form action=<?php print $action;?> method=POST>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$this->id;?>> 
<p>

<?php
$onclick="onclick=\"window.open('','window1','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<table align=center>
<tr>
   <td><?php print $lang->delivery_zone_cols['zone']?></td>
   <td><input type=text size=30 name=item[name] value="<?php print @$rec->data['name'];?>"><br>
   <?php $theme->form_error('name');?>
   </td>
</tr>

<tr>
  <td><?php print $lang->delivery_zone_cols['country']?></td>
   <td>
	<?php
	global $database;
	if(!empty($rec->data['country'])) {
		if(is_array($rec->data['country'])) {
			$select_del_country=$rec->data['country'];
		} else {	
			$select_del_country=unserialize($rec->data['country']);
		}
	}		
	if(!empty($select_del_country)) {
		$tmp = array_flip ($select_del_country);
	} else {
		$tmp=array();
	}
	// jesli nie jest pusta tablica z krajami to z niej wez wartosci
	if(!empty($config->country_select)) {
		$str="<select class=form name=\"item[country][]\" size=\"10\" multiple>\n";
		foreach($config->country_select as $key=>$value) {
			if(array_key_exists($key, $tmp)) {			
				$str.="<option  value=\"".$key."\" selected>".$lang->country[$key]."</option>\n";
			} else {
				$str.="<option  value=\"".$key."\">".$lang->country[$key]."</option>\n";
			}	
		}
		$str.="</select>\n";		
	} 
	if(empty($str)) {
		// jesli tablica jest pusta to sprobuj to wziac z bazy danych
		$str=$database->sql_select_multiple("delivery_country","item[country][]","name_short","name_long","","","",10,@$select_del_country);
	}
	if(empty($str)) {
		$str="<select class=form name=\"item[country][]\" size=\"10\" multiple>\n";
		foreach($lang->country as $key=>$value) {
			if(array_key_exists($key, $tmp)) {			
				$str.="<option  value=\"".$key."\" selected>".$lang->country[$key]."</option>\n";
			} else {
				$str.="<option  value=\"".$key."\">".$lang->country[$key]."</option>\n";
			}	
		}
		$str.="</select>\n";		
	} 
	
	print $str;
	?>
   </td>
</tr>
<tr><td></td><td>
<?php 
		global $country_error;
		$theme->form_error('country');
		if(!empty($country_error)) {
			$cnt=$country_error[0]['country'];
			print "<b>".$lang->country[$cnt]."</b><br>";
			print $lang->delivery_zone_info;
			foreach($country_error as $key=>$value) {
				print "::<b>".$value['name']."</b>";
			}
			print "<br>".$lang->delivery_zone_info1;
		}	
?> </td></tr>

<?php if(!empty($select_del_country)) { ?>
<tr>
	<td><?php print $lang->delivery_zone_cols['current_country']?></td>
	<td align="left">
	<?php
	if(!empty($select_del_country)) {
		foreach($select_del_country as $value) {
			print $lang->country[$value]."<br>";
		}
	}	
	?>
	</td>
</tr>
<?php } ?>

<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>

<?php if(!empty($this->id)) { 
	global $mdbd;
	$data=$mdbd->select("id,name","delivery","delivery_zone LIKE '%i:$this->id%'","","","array");
	if(!empty($data)) {
	?>
<tr>
	<td><?php print $lang->delivery_zone_cols['price_zone']?></td>
	<td align="left">
	<?php
	if(!empty($data)) {
	print "<table>";
		foreach($data as $key=>$value) {
			print "<tr><td>".$value['name']."</td><td><a href=\"volume_price.php?id_delivery=".$value['id']."&id_zone=".$this->id."\" onclick=\"window.open('', 'window_2', 'width=400, height=300, status=0, resizable=1')\" target=window_2><b><u>".$lang->delivery_zone_cols['define_price']."</u></b><a></td></tr>";
		}
	print "</table>";
	}}
	?>
	</td>
</tr>
<?php } ?>


</table>

</form>