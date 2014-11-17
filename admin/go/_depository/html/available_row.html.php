<?php
/**
* @version    $Id: available_row.html.php,v 1.1 2005/11/18 15:32:47 lechu Exp $
* @package    options
* @subpackage available
*/
$onclick="onclick=\"open_window(425,200)\"";
$id=$rec->data['user_id'];

global $config,$lang;

$arr_tmp = array();
if(!empty($config->depository_interval["$id"])) {
    $arr_tmp = explode(";", $config->depository_interval["$id"]);
}
$interval_from = @$arr_tmp[0];
$interval_to = @$arr_tmp[1];
?>
<tr>
   <td>
        <?php print $rec->data['user_id'];?>
   </td>
   <td>
        <?php print $rec->data['name'];?>
   </td>
   <td>
        <input type="text" style="width: 40px;" name="form[<?php echo $id; ?>][from]" value="<?php echo @$interval_from; ?>">
   </td>
   <td>
        <input type="text" style="width: 40px;" name="form[<?php echo $id; ?>][to]" value="<?php echo @$interval_to; ?>">
   </td>
</tr>
