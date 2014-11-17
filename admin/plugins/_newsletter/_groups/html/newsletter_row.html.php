<?php
/**
* Edycja danych adresu e-mail, przypisanie do grupy
* 
* @author  rdiak@sote.pl
* @version $Id: newsletter_row.html.php,v 2.8 2004/12/20 18:00:14 maroslaw Exp $
*
* verified 2004-03-09 m@sote.pl
* @package    newsletter
* @subpackage groups
*/

$onclick="onclick=\"open_window(350,200)\"";
$id=$rec->data['id'];
$user_id=$rec->data['user_id'];
global $lang;
global $database;
$rec->data['count']=$database->sql_select_like("count(*)","newsletter","groups LIKE '%:$user_id:%'"); 

?>
<tr>
   <td>
  <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   <?php print $rec->data['user_id'];?>
    </a>
   </td>
   	<td>
  	 <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   	 <?php print $lang->change_img;?>
   	 </u>    	 
   	 </a>
   </td> 
   <td>
  <a href=/plugins/_newsletter/_users/list.php?group=<?php print $user_id;?>><u>
   <?php print $rec->data['name'];?>
   </td>
   <td>
   <?php print $rec->data['count'];?>
   </td>
   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
    </td>
</tr>

<?php
$this->lastRow(4);
?>
