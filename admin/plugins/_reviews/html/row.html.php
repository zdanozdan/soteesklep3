<?php
/**
 * PHP Template:
 * Prezentacja wiersza rekordu
 * 
 * @author piotrek@sote.pl
 * @version $Id: row.html.php,v 1.10 2005/10/20 06:44:59 krzys Exp $
* @package    reviews
 */

$onclick="onclick=\"window.open('','window','width=360,height=450,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
$id=$rec->data['id'];
require_once("include/description.inc");
$my_desc=new Description;
$my_desc->maxchars=50;

$short_desc=$my_desc->short("",$rec->data['description']);

global $lang;
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $id;?></u></a>
   </td>
   <td>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $lang->change_img;?></u></a>
   </td>
   <td align=center>
       <?php print $rec->data['user_id']; ?> 
   </td>
   <td>
   <?php
   if (!empty($rec->data['author_id'])){
   print "<b><a target=\"_blank\" href=\"/go/_users/edit.php?id=".$rec->data['author_id']."\">".$rec->data['author']."</a></b>";
   }else{
       print $rec->data['author'];
   }
       ?>
   </td>
   <td>
       <?php print $short_desc;?>
   </td>
   <td align=center>
      <?php print $rec->data['score'];?>
   </td>
   <td align=center>
      <?php print $rec->data['date_add'];?>
   </td>
   <td align=center> 
      <?php if ($rec->data['state']==1) print $lang->yes;
            else print "<font color=red>".$lang->no."</font>\n";
      ?>
   </td>
   <td align=center>
      <?php print $rec->data['lang'];?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>

<?php
$theme->lastRow(9);
?>
