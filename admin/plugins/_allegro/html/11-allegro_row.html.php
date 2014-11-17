<?php
$onclick="onclick=\"open_window(425,525)\"";
$id=$rec->data['id'];
global $config,$lang;

?>
<tr>
  <td><a href="/go/_edit/edit_allegro.php?id=249" target="window">
    <?php print $rec->data['id'];?></a>
  </td>
   <td><a href="/go/_edit/edit_allegro.php?id=249" target="window"><u>
     <?php print $rec->data['allegro_product_name'];?></u></a>
    </td>
   <td>
   <?php print $rec->data['allegro_price_start']."&nbsp;".$config->currency;?>
   </td>
   <td align="center">
   <?php print $rec->data['allegro_send'];?>
   </td>
   <td align="center">
   <nobr><input type=checkbox name=send[<?php print $rec->data['user_id'];?>]><?php print $lang->allegro_send;?></nobr>
   </td>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
   </td>
</tr>

<?php
$theme->lastRow(6);
?>