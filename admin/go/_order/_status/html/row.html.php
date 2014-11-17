<?php
/**
* Prezentacja wiersza statusu na li¶cie.
*
* @author  m@sote.pl
* @version $Id: row.html.php,v 2.5 2005/01/14 11:32:40 maroslaw Exp $
* @package    order
* @subpackage status
*/

$id=$rec->data['id'];
global $lang;
?>
<tr>
   <td>
     <a href=edit.php?id=<?php print $id;?> onClick="open_window(600,400);" target=window><u>
     <?php print $rec->data['user_id'];?>
     </u></a>
   </td>
   <td>
     <a href=edit.php?id=<?php print $id;?> onClick="open_window(600,400);" target=window>
     <?php print $lang->change_img;?>
     </a>
   </td>
   <td>
     <?php print $rec->data['name'];?>
   </td>
   <td align=center>
     <?php print $theme->yesno($rec->data['send_mail']);?>
   </td>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
   </td>
</tr>
<?php
$theme->lastRow(4);
?>
