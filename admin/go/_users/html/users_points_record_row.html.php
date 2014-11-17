<?php
/**
* @version    $Id: users_points_record_row.html.php,v 1.5 2005/12/12 14:29:49 krzys Exp $
* @package    users
*/
$id=$rec->data['id'];
global $lang;
?>

<tr>
	<td>
		<?php print $lang->user_points[$rec->data['type']];?>
	</td>
	<td align="center">
		<?php 
		if ($rec->data['type'] =='add'){
			print "<font color=\"43a214\"><b>+".$rec->data['points']."</b></font>";
		}else{
			print "<font color=\"e81010\"><b>-".$rec->data['points']."</b></font>";
		} ?>
	</td>
	<td align="center">
		
		<?php
		
		if (preg_match("/[-:]+/",$rec->data['date_add'])){
		print $rec->data['date_add'];
		}else{
		$year = substr($rec->data['date_add'], 0, 4);
		$month = substr($rec->data['date_add'], 4, 2);
		$day = substr($rec->data['date_add'], 6, 2);
		$hour = substr($rec->data['date_add'], 8, 2);
		$minutes = substr($rec->data['date_add'], 10, 2);
		print $day."-".$month."-".$year."  ".$hour.":".$minutes;
		}
		?>
	</td>
	<td>
		<?php 
		if ($rec->data['description']=='recommend'){
			print $lang->user_points['for_recommend'];
		}elseif ($rec->data['description']=='product'){
			print $lang->user_points['for_product'];
		}elseif ($rec->data['description']=='review'){
			print $lang->user_points['for_review'];
		}else{
			print $rec->data['description'];
		}
		?>
	</td>
	<td align="center">
		<?php 
		if ($rec->data['order_id']==0){
		$rec->data['order_id']="-";
		}
		if ($rec->data['order_id']!="-") {
			print "<a href=/go/_order/edit.php?order_id=".$rec->data['order_id'].">".$rec->data['order_id']."</a>";
		} else {
			print $rec->data['order_id'];
		}
		?>
	</td>
	<td align="center">
		<?php
		if ($rec->data['user_id_main']==0){
		$rec->data['user_id_main']="-";	
		} 
		print $rec->data['user_id_main'];
		?>
	</td>
</tr>