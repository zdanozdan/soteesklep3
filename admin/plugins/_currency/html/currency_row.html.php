<?php
/**
* Szablon prezentujacy liste walut dostepnych w sklepie
*
* 
* @version $Id: currency_row.html.php,v 2.6 2004/12/20 17:59:30 maroslaw Exp $
* 
* @package    currency
*/
$onclick="onclick=\"open_window(325,155)\"";
$id=$rec->data['id'];
global $lang;

?>
<tr>
   <td>
   <?php if ($rec->data['id']!=1) { ?>
        <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   <?php } ?>

   <?php print $rec->data['id'];?>

   </u>
   <?php if ($rec->data['id']!=1) { ?>
       </a>
   <?php } ?>
   </td>
     <td>
     <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
     <?php print $lang->change_img;?>
     </u>
     </a>
   </td>
   <td>
   <?php if ($rec->data['id']!=1) { ?>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   <?php } ?>
   <?php print $rec->data['currency_name'];?>

   </u>
      <?php if ($rec->data['id']!=1) { ?>
   </a>
    <?php } ?>
   </td>
   <td>
   <?php print $rec->data['currency_val'];?>
   </td>
   <td>
   <?php print $rec->data['date_update'];?>
   </td>
    <?php if ($rec->data['id']!=1) { ?>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
   </td>
  <?php } ?>
    
</tr>
<?php
$this->lastRow(5);
?>
