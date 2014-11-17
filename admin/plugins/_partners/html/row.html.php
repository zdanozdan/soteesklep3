<?php
/**
 * Prezentacja wiersza rekordu
 * 
 * @author  pmalinski@sote.pl
 * \@template_version Id: row.html.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: row.html.php,v 1.6 2005/04/22 13:03:20 scalak Exp $
* @package    partners
 */

$id=$rec->data['id'];
global $lang;
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(400,250)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
   		<a href=edit.php?id=<?php print $id;?> onclick="open_window(400,250)" target=window><u><?php print $lang->change_img;?></u></a>
   </td>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(400,250)" target=window><u><?php print $rec->data['partner_id'];?></u></a>
   </td>
   
   <td align=center>
       <?php print $rec->data['name'];?>
   </td>
   <td align=center>
       <?php print $rec->data['www'];?>
   </td>
   <td align=center>
       <?php print $rec->data['email'];?>
   </td>
   <td align=center>
       <?php print $rec->data['rake_off'];?>
   </td>
     <?php if ($rec->data['name']!='onet' AND $rec->data['name']!='wp' AND $rec->data['name']!='interia') { ?>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
   <?php } ?>
 
   </tr>

<?php
$theme->lastRow(7);
?>
