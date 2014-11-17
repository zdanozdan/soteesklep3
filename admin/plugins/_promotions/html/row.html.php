<?php
/**
 * Prezentacja wiersza rekordu
 * 
 * @author  m@sote.pl
 * \@template_version Id: row.html.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: row.html.php,v 1.6 2004/12/20 18:00:44 maroslaw Exp $
* @package    promotions
 */

$id=$rec->data['id'];
global $lang;
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(746,600)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
   <a href=edit.php?id=<?php print $id;?> onclick="open_window(746,600)" target=window><u><?php print $lang->change_img;?></u></a>
   </td>
   <td>
       <?php print $rec->data['name'];?>
   </td>
   <td>
       <?php print $rec->data['active'];?>
   </td>
   <td>
       <?php print $rec->data['lang'];?>
   </td>   
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php
$theme->lastRow(5);
?>
