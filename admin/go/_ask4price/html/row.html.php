<?php
/**
 * PHP Template:
 * Prezentacja wiersza rekordu
 * 
 * @author m@sote.pl lech@sote.pl
 * @version $Id: row.html.php,v 1.2 2005/06/30 12:24:50 lechu Exp $
* @package    ask4price
* \@ask4price
 */
$id=$rec->data['request_id'];
$onclick="href='/go/_ask4price/edit.php?id=$id' onclick=\"window.open('', 'window3', 'width=700, height=550, status=0, toolbar=0, resizable=1, scrollbars=1')\" target='window3'";
global $lang;
if(empty($rec->data['id_users'])) {
    $rec->data['id_users'] = $lang->ask4price_not_logged;
}
else {
    $rec->data['id_users'] = "<a href='/go/_users/edit.php?id=" . $rec->data['id_users'] . "' onclick=\"window.open('', 'window4', 'width=780, height=580, status=0, toolbar=0, resizable=1, scrollbars=1')\" target='window4'>" . $rec->data['id_users'] . "</a>";
}
    
if ($rec->data['active'] == 1)
    $rec->data['active'] = "<span style='color: red;' >" . $lang->no . "</span>";
else
    $rec->data['active'] = $lang->yes;
?>
 
<tr>
 	<td>
   	<a <?php print $onclick;?> ><u>
   	<?php print $id;?>
   	</u></a>
   	</td>
   	<td>
    	<a <?php print $onclick;?> ><u>
    	<?php print $lang->change_img;?>
    	 </u>
    	 </a>
   	</td>
   	
	<td align=center><?php print $rec->data['name_company'];?></td>
	<td align=center><?php print $rec->data['email'];?></td>
	<td align=center><?php print $rec->data['id_users'];?></td>
	<td align=center><?php print $rec->data['date_add'];?></td>
	<td align=center><?php print $rec->data['active'];?></td>
	
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>
<?php
$theme->lastRow(7);
?>
