<?php
/**
* @version    $Id: available_row.html.php,v 2.5 2005/11/25 11:49:59 lechu Exp $
* @package    options
* @subpackage available
*/
$onclick="onclick=\"open_window(425,200)\"";
$id=$rec->data['id'];
global $config,$lang;
?>
<tr>
   <td>
   <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   <?php print $rec->data['user_id'];?>
   </u></a>
   </td>
   <td>
    <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
    <?php print $lang->change_img;?>
     </u>
     </a>
   </td>
   <td>
   
    <?php print $rec->data['name'];?>
   </td>
   <td bgcolor="#dddddd" align="center">
   
    <input type="text" style="width: 25px;" name="form_intervals[<?php echo $rec->data['user_id']; ?>][from]" value="<?php print $rec->data['num_from'];?>" >
   </td>
   <td bgcolor="#dddddd" align="center">
   
    <input type="text" style="width: 25px;" name="form_intervals[<?php echo $rec->data['user_id']; ?>][to]" value="<?php print $rec->data['num_to'];?>" >
   </td>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
   </td>
</tr>

<?php
$theme->lastRowIntervals(5);
?>
