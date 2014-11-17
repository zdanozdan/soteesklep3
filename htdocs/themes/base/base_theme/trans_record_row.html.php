<?php
/**
* @version    $Id: trans_record_row.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

global $lang,$config, $_SESSION;

if (($rec->data['confirm']==1) || ($rec->data['confirm_online'])) {
    $confirm=$lang->bool["1"];
} else $confirm="<font color=red>".$lang->bool["0"]."</font>";

$id=$rec->data['id'];
$order_id=$rec->data['order_id'];

$id_status=$rec->data['id_status'];
if (! empty($config->order_status[$id_status])) {
    $status=$config->order_status[$id_status];
} else $status="---";

if (strlen($status)>16) {
    $status=substr($status,0,10)."...".substr($status,strlen($status)-5,5);
}
?>
  <tr> 
    <td align="center"><a href="/go/_users/order_info.php?id=<?php print $order_id;?>"><?php print $rec->data['order_id'];?></a></td>
    <td align="center"><?php print $rec->data['date_add'];?></td>
    <?php if (@$rec->data['points']==0) {?>
	    <td align="right"><nobr><?php print $rec->data['total_amount']." ".$config->currency;?></nobr></td>
    <?php } else {?>
	    <td align="right"><nobr><?php print $rec->data['points_value']." ".$lang->points_unit;?></nobr></td>
    <?php }?>
    <td align="center"><?php print $status;?></td>
<!--
    <td align="center"><?php //print $confirm;?></td>
-->
    <td align="center"><?php print @$config->pay_method[$rec->data['id_pay_method']];?></td>
    <?php
    if(empty($_SESSION['id_partner'])) {
    ?>
    <td align=center><a href="javascript:window.open('/go/_contact/contact.php?subject=<?php print $lang->plugins_transuser_ask4trans.$rec->data['order_id'];?>', 'window', 'toolbar=0, status=0, resizable=1, scrollbars=1, width=450, height=350'); void(0);" onMouseOver="window.status=' '; return true;"><?php print $lang->plugins_transuser_ask4;?></a></td>
    <?php
    }
    ?>
  </tr>
