<?php
/**
 * Prezentacja wiersza rekordu
 * 
 * @author  lech@sote.pl
 * @template_version Id: row.html.php,v 2.6 2004/02/12 10:59:12 maroslaw Exp
 * @version $Id: row.html.php,v 1.1 2005/11/18 15:29:06 lechu Exp $
 * @package soteesklep
 */

$id=$rec->data['id'];
global $lang;
$size="450,200";
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(<?php print $size;?>)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(<?php print $size;?>)" target=window><?php print $lang->change_img;?></a>
   </td>
   <td>
       <?php print $rec->data['name'];?>
   </td>
   <td>
       <?php print $rec->data['email'];?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php
$theme->lastRow(4);
?>