<?php
/**
 * Lista producentow
 * 
 * @author  m@sote.pl
 * \@template_version Id: row.html.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: row.html.php,v 1.3 2004/12/20 17:58:12 maroslaw Exp $
* @package    edit_producer
 */

$id=$rec->data['id'];
global $lang;
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(450,200)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
    <a href=edit.php?id=<?php print $id;?> onclick="open_window(450,200)" target=window><u><?php print $lang->change_img;?></u></a>
   </td>
   <td>
       <?php print $rec->data['producer'];?>
   </td>
   <td>
    <a href=/go/_category/producer.php?id_producer=<?php print $id;?>&producer_filter=<?php print $id;?>><?php print $lang->edit_producer_products;?></a>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php
$theme->lastRow(4);
?>
