<?php
/**
 * Prezentacja wiersza rekordu
 * 
 * @author  m@sote.pl
 * \@template_version Id: row.html.php,v 2.3 2003/07/11 15:48:09 maroslaw Exp
 * @version $Id: row.html.php,v 1.5 2005/10/12 13:53:46 lukasz Exp $
* @package    main_keys
* @subpackage main_keys_ftp
 */

$id=$rec->data['id'];
global $lang,$theme;
global $mdbd;
$name=$mdbd->select("name_L0","main","user_id=?",array($rec->data['user_id_main']=>"text"),"LIMIT 1");
?>

<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(450,200)" target=window><u><?php print $rec->data['id'];?></u></a>
   </td>
   <td>
       <a href=edit.php?id=<?php print $id;?> onclick="open_window(450,200)" target=window><u><?php print $lang->change_img;?></u></a>  
   </td>      
   <td>
       <?php 
       if (! empty($name)) {
           print "<a href=/go/_edit/index.php?user_id=".$rec->data['user_id_main']." onclick=\"open_window(760,580)\" target=window><u>".$rec->data['user_id_main'].", $name</u></a>";
       } else {
           print $lang->main_keys_ftp_unknown;
       }
       ?>
   </td>
   <td>
       <?php print $rec->data['ftp'];?>
   </td>
   <td align=center>
       <?php print $theme->yesno($rec->data['active']);?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>
<?php
$theme->lastRow(5);
?>
