<?php
/**
* Prezentacja wiersza rekordu.
*
* @author m@sote.pl
* @version $Id: row.html.php,v 2.4 2004/12/20 17:57:51 maroslaw Exp $
* @package    admin_users
*/

$onclick="onclick=\"window.open('','window','width=360,height=250,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$id=$rec->data['id'];
global $lang;
?>
 
<tr>
   <td>
    <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $rec->data['login'];?></u></a>
   </td>
   <td>
       <?php print $rec->data['type'];?>
   </td>
   <td>
   <?php
   if ($rec->data['active']==1) print $lang->yes;
   else print "<font color=red>".$lang->no."</font>\n";
   ?>
   </td>  
   <td>
   <?php
   if ($rec->data['id_admin_users_type']!=1) {
       print "<nobr><input type=checkbox name=del[$id]>$lang->delete</nobr>";
   }
   ?>
   </td>   
</tr>
<?php
$theme->lastRow(3);
?>
