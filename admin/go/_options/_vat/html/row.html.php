<?php
/**
 * PHP Template:
 * Prezentacja wiersza rekordu
 * 
 * @author m@sote.pl
 * \@template_version Id: row.html.php,v 2.1 2003/03/13 11:28:59 maroslaw Exp
 * @version $Id: row.html.php,v 1.3 2004/12/20 17:58:44 maroslaw Exp $
* @package    options
* @subpackage vat
 */
$onclick="onclick=\"open_window(425,200)\"";
$id=$rec->data['id'];
global $lang;
?>
 
<tr>
 	<td>
   	<a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
   	<?php print $rec->data['id'];?>
   	</u></a>
   	</td>
   	<td>
    	<a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u>
    	<?php print $lang->change_img;?>
    	 </u>
    	 </a>
   	</td>
   	
	<td align=center>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $rec->data['vat'];?></u></a>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>
<?php
$theme->lastRow(3);
?>
