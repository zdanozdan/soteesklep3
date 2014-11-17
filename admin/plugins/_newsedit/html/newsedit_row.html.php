<?php
/**
* Szablon wiersza newsa na li¶cie newsów.
*
* @author  m@sote.pl
* @version $Id: newsedit_row.html.php,v 2.5 2004/12/20 18:00:09 maroslaw Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

$id=$rec->data['id'];
global $lang,$theme;

?>
<tr>
   <td>
    <a href=edit.php?id=<?php print $id;?> onClick="open_window(760,850);" target=window><u>
   <?php print $rec->data['id'];?>
   </u></a>
   </td>
   <td>
    <a href=edit.php?id=<?php print $id;?> onClick="open_window(760,850);" target=window>
    <?php print $lang->change_img;?></a>
   </td>
   <td>
   <a href=edit.php?id=<?php print $id;?> onClick="open_window(760,850);" target=window><u>
   <?php print $rec->data['subject'];?>
   </u></a>
   </td>
   <td>
   <?php print $rec->data['date_add'];?>
   </td>
   <td>
   <?php print $theme->yesno($rec->data['active']);?>
   </td>
   
   <td align=center>
   <?php print $rec->data['ordercol'];?>
   </td>
   
   <td>
   <?php print $rec->data['id_newsedit_groups']." ".$rec->data['group'];?>
   </td>
   
   <td>
   <?php
   print "<nobr><input type=checkbox name=del[$id]>$lang->delete</nobr>\n";
   ?>
   </td>
</tr>

<?php
$theme->lastRow(7);
?>
