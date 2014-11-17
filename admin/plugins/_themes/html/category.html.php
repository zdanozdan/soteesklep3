<?php
/**
* @version    $Id: category.html.php,v 1.5 2004/12/20 18:00:57 maroslaw Exp $
* @package    themes
*/
if (@$config->category['openall']==1) $openall_on="checked";
if (@$config->category['icons']==1) $icons_on="checked";
if (@$config->category['type']=="treeview") $category_treeview_on = "checked";
if (@$config->category['type']=="standard") $category_standard_on = "checked";
if (@$config->category['type']=="hybrid")   $category_hybrid_on   = "checked";
?>

<center>
<BR>
<?php 
print $lang->themes_category_choose;
?>
<BR><BR>
</center>
<form action=category.php name=categoryForm>
<table width=70% align=center>
<tr> 
  <td>
     1. <?php print $lang->themes_category_info['treeview_icons'];?><br>       
  </td>
  <td></td>
  <td>

    <table cellspacing=0 cellpadding=0>
    <tr>
      <td><img src=<?php $theme->img("_img/_themes/ftv2pnode.gif");?>></td>
      <td width=20></td>
      <td><img src=<?php $theme->img("_img/_themes/ftv2pnode.gif");?>></td>
      <td><img src=<?php $theme->img("_img/_themes/ftv2folderclosed.gif");?>></td>
      <td> <input type=checkbox name=category[icons] value=1 <?php print @$icons_on;?>></td>
    </tr>
    </table>

  </td>
</tr>
<tr>
  <td valign=top>
   <P><BR>
    2. <?php print $lang->themes_category_info['treeview_producers'];?>
    <br>  
  </td>
  <td valign=top><BR>
    <input type=radio name=category[type] value=treeview <?php print @$category_treeview_on;?>>
  </td>
  <td valign=top>   
    <img src=<?php $theme->img("_img/_themes/category.png");?>>
  </td>
</tr>
<tr>
   <td valign=top>
       2.1 <?php print $lang->themes_category_info['treeview_openall'];?><BR>
 <i>(<a href=/go/_opt/index.php><font size=-1><?php print $lang->themes_category_opt;?></font></a>)</i>
 
   <br>
  </td>
  <td valign=top>
         <input type=checkbox name=category[openall] value=1 <?php print @$openall_on;?>>
   </td>
</tr>
<tr>
  <td valign=top>
   <P><BR>
   3. <?php print $lang->themes_category_info['static'];?>
  </td>
  <td valign=top><BR>
    <input type=radio name=category[type] value=standard <?php print @$category_standard_on;?>>
  </td>
  <td valign=top>   
  </td>
</tr>
<tr>
  <td valign=top>
   <P><BR>
   4. <?php print $lang->themes_category_info['hybrid'];?>
  </td>
  <td valign=top><BR>
    <input type=radio name=category[type] value=hybrid <?php print @$category_hybrid_on;?>>
  </td>
  <td valign=top>   
  </td>
</tr>
</table>
  <center><?php $buttons->button($lang->update,"javascript:document.categoryForm.submit();");?></center> 
</form>
