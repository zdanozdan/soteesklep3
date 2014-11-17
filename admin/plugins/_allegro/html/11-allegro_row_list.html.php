<?php
$onclick="onclick=\"open_window(425,525)\"";
$id=$rec->data['id'];
global $config,$lang,$allegro_config;

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
   <td>
   <?php 
   if($rec->data['allegro_send'] == 'product') {
       print "<a href=\"http://www.allegro.pl/show_item.php?item=".$rec->data['allegro_number']."\" target=window><u>".$rec->data['allegro_number']."</u></a>";
   } else {
       print "<a href=\"http:///www.testwebapi.pl/show_item.php?item=".$rec->data['allegro_number']."\" target=window><u>".$rec->data['allegro_number']."</u></a>";
   }
   ?>
   </td>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
   </td>
   </tr>
<?php
$theme->lastRow(6);
?>