<?php
/**
* @version    $Id: points_record_row.html.php,v 1.1 2006/09/27 21:53:22 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

global $lang,$config;

$type=$rec->data['type'];
$points=$rec->data['points'];
$date_add=$rec->data['date_add'];
$description=$rec->data['description'];
$order_id=$rec->data['order_id'];
$user_id_main=$rec->data['user_id_main'];
?>
  <tr> 
    <td align="center"><?php print $lang->user_points[$rec->data['type']];?></td>
    <td align="center">
    <?php
    if ($type =='add'){
    	print "<font color=\"43a214\"><b>+".$points."</b></font>";
    }else{
    	print "<font color=\"e81010\"><b>-".$points."</b></font>";
    }
    ?>
    </td>
    <td align="center"><?php 
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
    <td align="left"><?php 
    if ($rec->data['description']=='recommend'){
    	print $lang->user_points['for_recommend'];
    }elseif ($rec->data['description']=='product'){
    	print $lang->user_points['for_product'];
    }elseif ($rec->data['description']=='review'){
    	print $lang->user_points['for_review'];
    }else{
    	print $rec->data['description'];
    }
		?></td>
    <td align="center">
    <?php 
    if ($rec->data['order_id']==0){
    	$rec->data['order_id']="-";
    }
    print $rec->data['order_id'];
		?></td>
    <td align="center">
    <?php
    if ($rec->data['user_id_main']==0){
    	$rec->data['user_id_main']="-";
    }
    print $rec->data['user_id_main'];
		?>
    </td>
    
  </tr>
