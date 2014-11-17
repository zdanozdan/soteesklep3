<?php
/**
* Menu g³ówne newsów.
*
* @author  m@sote.pl
* @version $Id: menu_top.inc.php,v 2.5 2005/01/03 15:00:21 lechu Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

// zmieñ/ustaw grupe
include_once ("plugins/_newsedit/include/change_group.inc.php");
?>

<table>
<tr>
   <td>
      <?php    
      require_once ("MetabaseData/DataForm.php");
      $data=$mdbd->select("id,name","newsedit_groups","1",array(),"","ARRAY");          
      $form = new DataForm($mdbd,"/plugins/_newsedit/index.php","POST","newseditGroupForm");      
      $form->default_select=$lang->newsedit_groups_all;
      $form->dbMemSelect($data,"group",$lang->newsedit_groups_select,@$__newsedit_group['id']);      
      $form->dbMemDisplaySelect("group");     
      ?>
   </td>
   <td>
      <?php 
      $buttons->button($lang->change,"\"javascript:document.newseditGroupForm.submit();\"");
      ?>
   </td>
      <?php 
      $form->end();
      ?>
   <td>
      <?php 
      $buttons->button($lang->newsedit_edit_group,"/plugins/_newsedit/_newsedit_groups/index.php");
      ?>
   </td>
   <td>
      <?php 
      $buttons->button($lang->newsedit_news,"/plugins/_newsedit/index.php");
      ?>
   </td>
   <td>
      <?php 
      $buttons->button($lang->newsedit_menu["configure"],"/plugins/_newsedit/configure.php");
      ?>
   </td>
</tr>
</table>
