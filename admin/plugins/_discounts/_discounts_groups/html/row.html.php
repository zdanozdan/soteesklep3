<?php
/**
 * PHP Template:
 * Prezentacja wiersza rekordu
 * 
 * @author m@sote.pl
 * \@template_version Id: row.html.php,v 2.1 2003/03/13 11:28:59 maroslaw Exp
 * @version $Id: row.html.php,v 1.4 2004/12/20 17:59:42 maroslaw Exp $
* @package    discounts
* @subpackage discounts_groups
 */

$onclick="onclick=\"window.open('','window','width=550,height=420,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$id=$rec->data['id'];
global $lang;
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $rec->data['user_id'];?></u></a>
   </td>
   <td>
       <?php print $rec->data['group_name'];?>
   </td>
  <td>
       <?php print $rec->data['default_discount'];?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>
