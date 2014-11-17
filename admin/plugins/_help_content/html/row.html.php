<?php
/**
* Prezentacja wiersza rekordu
*
* @author  lech@sote.pl
* \@template_version Id: row.html.php,v 2.6 2004/02/12 10:59:12 maroslaw Exp
* @version $Id: row.html.php,v 1.3 2004/12/20 17:59:50 maroslaw Exp $
* @package    help_content
*/

$id=$rec->data['id'];
global $lang, $config;
$size="450,400";
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(<?php print $size;?>)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(<?php print $size;?>)" target=window><?php print $lang->change_img;?></a>
   </td>
   <td>
       <?php 
       if ($config->admin_lang=='pl'){
    print $rec->data['title'];
}else{
    print $rec->data['title_en'];
}
      
       ?>
   </td>
   <td>
       <?php print $rec->data['author'];?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php
$theme->lastRow(4);
?>
