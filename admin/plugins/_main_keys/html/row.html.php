<?php
/**
 * Prezentacja wiersza rekordu
 * 
 * @author  m@sote.pl
 * \@template_version Id: row.html.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: row.html.php,v 1.5 2005/07/19 13:36:17 lukasz Exp $
* @package    main_keys
 */

$id=$rec->data['id'];
global $lang;

// odczytaj nazwe produktu
global $mdbd;
global $__name;
if (empty($__name[$rec->data['user_id_main']])) {
    $__name[$rec->data['user_id_main']]=$mdbd->select("name_L0","main","user_id=?",array($rec->data['user_id_main']=>"text"),"LIMIT 1");
} 

$name=$__name[$rec->data['user_id_main']];
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(650,200)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(650,200)" target=window><u><?php print $lang->change_img;?></u></a>  </td>   
   <td>
   <?php 
   if (! empty($name)) {
       print "<a href=/go/_edit/index.php?user_id=".$rec->data['user_id_main']." onclick=\"open_window(760,580)\" target=window><u>".$rec->data['user_id_main'].", $name</u></a>";
   } else {
        print $lang->main_keys_unknown;   
   }
?>
   </td>
   <td>
       <?php print $rec->data['main_key'];?>
   </td>
   <td>   
   <?php  
   if ($rec->data['order_id']>0) {
       print "<a href=/go/_order/edit.php?order_id=".$rec->data['order_id']." onclick=\"open_window(760,580)\" target=window><u>".$rec->data['order_id']."</u></a>";
   }
   ?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php
$theme->lastRow(5);
?>
