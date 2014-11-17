<?php
/**
* Szablon prezentujacy liste walut dostepnych w sklepie
*
* 
* @version $Id: row.html.php,v 1.3 2005/02/09 13:56:01 scalak Exp $
* @package currency
* 
*/
$onclick="onclick=\"open_window(400,200)\"";
$id=$rec->data['id'];
global $lang;

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
   <td align="center">
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   <?php print $rec->data['name'];?>
   </u>
   </a>
   </td>
   
   <td align="center">
  <?php print $rec->data['range_max'];?>
   </td>

   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
   </td>
    
</tr>
<?php
$this->lastRow(5);
?>
