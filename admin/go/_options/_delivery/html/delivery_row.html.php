<?php
$onclick="onclick=\"open_window(425,525)\"";
$id=$rec->data['id'];
global $config,$lang;

?>
<tr>
  <td>
    <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
    <?php print $rec->data['id'];?>
    </u>
    </a>
  </td>
  <td>
     <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
     <?php print $lang->change_img;?>
     </u>
     </a>
   </td>
   <td>
     <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
     <?php print $rec->data['name'];?>
     </u>
     </a>
   </td>
   <td>
   <?php print $rec->data['free_from']."&nbsp;".$config->currency;?>
   </td>
   <td>
   <?php print $rec->data['price_brutto']."&nbsp;".$config->currency;?>
   </td>
   <td>
   <?php print $rec->data['order_by'];?>
   </td>
	<?php if($id !=1) { ?>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
   </td>
   <?php } ?>
</tr>

<?php
$theme->lastRow(6);
?>