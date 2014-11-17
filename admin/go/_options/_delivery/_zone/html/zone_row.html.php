<?php
/**
* Szablon prezentujacy liste walut dostepnych w sklepie
*
* 
* @version $Id: zone_row.html.php,v 1.5 2005/02/17 13:57:11 scalak Exp $
* @package currency
* 
*/
$onclick="onclick=\"open_window(760,550)\"";
$id=$rec->data['id'];
global $lang;

?>
<tr>
   <td valign="top">
   <?php if($rec->data['id'] !=1) { ?>
         <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
	<?php } ?>		
    <?php print $rec->data['id'];?>
   </u>
       </a>
   </td>
     <td valign="top">
    <?php if($rec->data['id'] !=1) { ?>
     <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
	<?php } ?>		
     <?php print $lang->change_img;?>
     </u>
     </a>
   </td>
   <td valign="top"> 
    <?php if($rec->data['id'] !=1) { ?>
   <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
	<?php } ?>		
   <?php print $rec->data['name'];?>
   </u>
   </a>
   </td>
   <td width="350">
   <?php 
   $country=unserialize($rec->data['country']);
   $str='';
   if(!empty($country)) {
   	foreach($country as $value) {
   		print $lang->country[$value].", ";
   	}
   }
   ?>
   </td>
   <td>
   <?php if($rec->data['id'] !=1) { ?>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
    <?php } ?>
   </td>
    
</tr>
<?php
$this->lastRow(5);
?>
