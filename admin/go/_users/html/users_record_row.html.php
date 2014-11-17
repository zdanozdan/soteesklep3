<?php
/**
* @version    $Id: users_record_row.html.php,v 1.3 2006/01/30 14:56:51 krzys Exp $
* @package    users
*/
$id=$rec->data['id'];
global $lang;
?>

<tr>
<td><a href=edit.php?id=<?php print $rec->data['id'];?> onclick="open_window(780,620)" target=window><u><?php print $rec->data['id'];?></u></a></td>
<td><a href=edit.php?id=<?php print $rec->data['id'];?> onclick="open_window(780,620)" target=window><u><?php print $lang->change_img;?></u></a></td>
<td><a href=edit.php?id=<?php print $rec->data['id'];?> onclick="open_window(780,620)" target=window><u><?php print $rec->data['login'];?></u></a></td>
<td><?php print $rec->data['name'];?></td>
<td><?php print $rec->data['surname'];?></td>
<td><?php print $rec->data['date_add'];?></td>
<td><a href='mailto:<?php print $rec->data['email'];?>'><u><?php print $rec->data['email'];?></u></a></td>
<td align=center><input type=checkbox name=del[<?php print $rec->data['id'];?>]><?php print $lang->go2trash;?></td>
</tr>

<?php
$theme->lastRow(7);
?>
