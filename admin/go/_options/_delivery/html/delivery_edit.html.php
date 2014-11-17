<?php $theme->desktop_open();?>

<form action=<?php print $action;?> method=post>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$id;?>> 
<p>

<table align=center>
<tr>
   <td><?php print $lang->delivery_cols['name']?></td>
   <td>
	<?php if(@$id !=1) { ?>
   		<input type=text size=30 name=delivery[name] value="<?php print @$rec->data['name'];?>">
 	<?php } else { ?>
    	<input type=text size=30 name=delivery[name] value="<?php print @$rec->data['name'];?>" readonly>
 	<?php } ?>
   <?php $theme->add2Dictionary(@$rec->data['name']);?>
       <br><?php $theme->form_error('name');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->delivery_cols['order_by']?></td>
   <td><input type=text size=2 name=delivery[order_by] value="<?php print @$rec->data['order_by'];?>"><br>
<?php $theme->form_error('order_by');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->delivery_cols['price_brutto']?></td>
   <td><input type=text size=8 name=delivery[price_brutto] value="<?php print @$rec->data['price_brutto'];?>">
   <?php print $config->currency;?><br>
<?php $theme->form_error('price_brutto');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->delivery_cols['vat']?></td>
   <td><input type=text size=4 name=delivery[vat] value="<?php print @$rec->data['vat'];?>">%<br>
  <?php $theme->form_error('vat');?>
</td>
</tr>
<tr>
   <td><?php print $lang->delivery_cols['free_from']?></td>
   <td><input type=text size=8 name=delivery[free_from] value="<?php print @$rec->data['free_from'];?>">
   <?php print $config->currency;?><br>
   <?php $theme->form_error('free_from');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->delivery_cols['delivery_info']?></td>
   <td><textarea rows=3 cols=30 name=delivery[delivery_info]><?php print @$rec->data['delivery_info'];?></textarea>
   <?php $theme->add2Dictionary(@$rec->data['delivery_info']);?>
   </td>
</tr>

<tr>
   <td><?php print $lang->delivery_cols['delivery_zone']?></td>
   <td>
   <?php 
   if(!empty($rec->data['delivery_zone'])) {
   		$rec->data['delivery_zone']=unserialize($rec->data['delivery_zone']);
   }		
   global $mdbd;
   $zone=$mdbd->select("id,name","delivery_zone");
   //print $rec->data['delivery_zone'];
   print "<table>\n";
   foreach($zone as $key=>$value) {
		if($value['id'] !=1) {
 			$checked="";
   			if(!empty($rec->data['delivery_zone'])) {
   				if (array_key_exists($value['id'],@$rec->data['delivery_zone'])) $checked="checked";
			}
			if(empty($rec->data['delivery_zone'][$value['id']])) {
				$rec->data['delivery_zone'][$value['id']]='';
			}
			print "<tr>\n";
   			print "<td>".@$value['name']."</td><td><input type=checkbox name=delivery_set[".@$value['id']."] value=1 ".@$checked."></td>\n";
			print "<td><input type=text size=5 name=delivery_price[".@$value['id']."] value=".$rec->data['delivery_zone'][$value['id']]."></td>\n";
   			print "</tr>\n";	
		}	
   }
   print "</table>\n";
   ?> 	 	
   </td>
</tr>

<tr>
   <td><?php print "<b>".$lang->delivery_cols['pay_method']."</b>"?></td>
   <td>
   <?PHP
   if(!empty($rec->data['delivery_pay'])) {
   		$rec->data['delivery_pay']=unserialize($rec->data['delivery_pay']);
    }		
    foreach($config->pay_method_active as $key=>$value) {
  			$checked="";
  			if(!empty($rec->data['delivery_pay'])) {
   				if (array_key_exists($key,@$rec->data['delivery_pay'])) $checked="checked";
			}
			print "<tr>\n";
   			print "<td>".$lang->pay_method[$key]."</td><td><input type=checkbox name=delivery_pay[".$key."] value=1 ".@$checked."></td>\n";
   			print "</tr>\n";	
   	}
   	?>
   </td>
</tr>

<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>
</table>
</form>

<?php $theme->desktop_close();?>
