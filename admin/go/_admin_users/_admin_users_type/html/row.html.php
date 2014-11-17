<?php
/**
* Prezentacja wiersza rekordu.
*
* @author m@sote.pl
* @version $Id: row.html.php,v 2.4 2004/12/20 17:57:47 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
*/

$onclick="onclick=\"window.open('','window','width=450,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$id=$rec->data['id'];
global $lang;
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $rec->data['type'];?></u></a>
   </td>
   <td>
      <?php
      if ($id>1) {
      ?>
      <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
      <?php
      }
      ?>
   </td>
</tr>
<?php
$theme->lastRow(1);
?>
