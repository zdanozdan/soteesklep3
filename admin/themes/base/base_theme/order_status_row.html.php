<?php
/**
* @version    $Id: order_status_row.html.php,v 1.2 2004/12/20 18:01:22 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
$onclick="onclick=\"window.open('','window','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$id=$rec->data['id'];
?>
<tr>
   <td>
   <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   <?php print $rec->data['user_id'];?>
   </u></a>
   </td>
   <td>
   <?php print $rec->data['name'];?>
   </td>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]>do kosza</nobr>
   </td>
</tr>
