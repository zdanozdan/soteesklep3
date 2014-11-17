<?php
/**
 * PHP Template:
 * Prezentacja wiersza rekordu
 * 
 * @author m@sote.pl
 * \@template_version Id: row.html.php,v 2.1 2003/03/13 11:28:59 maroslaw Exp
 * @version $Id: row.html.php,v 1.4 2004/12/20 18:00:49 maroslaw Exp $
* @package    reviews
* @subpackage scores
 */

require_once ("include/metabase.inc");

$onclick=$theme->onclick(300,230);
$id=$rec->data['id'];
$database = new my_Database;
global $lang;

$id_product=$rec->data['id_product'];
$user_id=$database->sql_select("user_id","main","id=$id_product");

$score_average=$rec->data['score_amount']/$rec->data['scores_number'];
$score_average_cut=ereg_replace("^([0-9]+\.[0-9][0-9]).*$","\\1",$score_average);
?>
 
<tr>
   <td>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $id;?></u></a>
   </td>
    <td>
       <a href=edit.php?id=<?php print $id;?> <?php print $onclick;?> target=window><u><?php print $lang->change_img;?></u></a>
   </td>
   <td align=center>
       <?php print $user_id; ?> 
   </td>
   <td align=center>
       <?php print $rec->data['score_amount']; ?>
   </td>
   <td align=center>
      <?php print $rec->data['scores_number'];?>
   </td>
   <td align=center>
      <?php print $score_average_cut;?>
   </td>
   <td>
       <nobr><input type=checkbox name=del[<?php print $id;?>]><?php print $lang->delete;?></nobr>   
   </td>
</tr>


<?php
$theme->lastRow(6);
?>
