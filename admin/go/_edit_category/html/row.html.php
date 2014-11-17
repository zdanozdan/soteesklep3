<?php
/**
 * Prezentacja wiersza rekordu
 * 
 * @author  m@sote.pl
 * \@template_version Id: row.html.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: row.html.php,v 1.3 2004/12/20 17:58:08 maroslaw Exp $
* @package    edit_category
 */

$id=$rec->data['id'];
global $lang;
global $__deep;

global $input_deep;
if (@$input_deep!=true) {
    print "<input type=hidden name=deep value=$__deep>";
    $input_deep=true;
}

?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id."&deep=$__deep";?> onclick="open_window(450,200)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
      <a href=edit.php?id=<?php print $id."&deep=$__deep";?> onclick="open_window(450,200)" target=window><u><?php print $lang->change_img;?></u></a>
   </td>
   <td>
       <?php print $rec->data["category$__deep"];?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php
$theme->lastRow(3);
?>
