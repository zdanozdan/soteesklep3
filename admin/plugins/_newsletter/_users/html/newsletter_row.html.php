<?php
/**
* Wiersz rekordu adresu e-mail na li¶cie newslettera
*
* @author  rdiak@sote.pl
* @version $Id: newsletter_row.html.php,v 2.8 2004/12/20 18:00:19 maroslaw Exp $
*
* verified 2004-03-09 m@sote.pl
* @package    newsletter
* @subpackage users
*/

$onclick="onclick=\"open_window(400,400)\"";
$id=$rec->data['id'];
global $lang,$theme;

?>
<tr>
   <td>
   <?php print $rec->data['id'];?>
   </td>
     
   	<td>
  	 <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   	 <?php print $lang->change_img;?>
   	 </u>    	 
   	 </a>
   </td> 	
   
   <td>
      <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   <?php print $rec->data['email'];?>
   </td>
   <td align=center>
   <?php print $rec->data['date_add'];?>
   </td>
   <td align=center>
   <?php print $theme->yesno($rec->data['status']);?>
   </td>
   <td>
   <?php print $rec->data['lang'];?>
   </td>

   <td>
   <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>
    </td>
</tr>

<?php
$this->lastRow(5);
?>
