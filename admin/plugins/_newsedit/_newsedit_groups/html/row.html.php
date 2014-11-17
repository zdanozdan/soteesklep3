<?php
/**
* Prezentacja wiersza rekordu
*
* @author  m@sote.pl
* \@template_version Id: row.html.php,v 2.5 2004/02/12 10:47:50 maroslaw Exp
* @version $Id: row.html.php,v 1.5 2004/12/20 18:00:06 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
* @subpackage newsedit_groups
*/

$id=$rec->data['id'];
global $lang;
$size="450,250";
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
   <?php   
   // grupy o id=1 nei mozna usunac
   if ($id>1) {
       print "<nobr><input type=checkbox name=del[$id]>$lang->delete</nobr>\n";
   }
   ?>     
   </td>
</tr>

<?php
$theme->lastRow(3);
?>
