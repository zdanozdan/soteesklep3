<?php
/**
* Edycja opcji zwi±zanych z pasaz.ceneo.pl
*
* @author  rdiak@sote.pl
* @version $Id: edit_ceneo.html.php,v 2.3 2006/08/16 10:20:55 lukasz Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/
?>
<!-- pasaz.ceneo.pl -->
<?php 
global $action;
global $DOCUMENT_ROOT;

if (in_array("ceneo.pl",$config->plugins)) {
    // ceneo_export
    if ($rec->data['ceneo_export']=="1") $checked_ceneo_export="checked"; else $checked_ceneo_export="";
    $theme->desktop_open();
?>
<form action="edit_ceneo.php?id=<?php print $_REQUEST['id']; ?>" method=post name=editForm  enctype=multipart/form-data>
<input type=hidden name=update value=true>

<table cellpadding="3" cellspacing="3" border=0 align="center">
<tr>
  
  <td><img src="<?php $theme->img('_img/ceneo.png');?>"></td>
</tr>

<tr>
  <td>
    <input type=checkbox name=item[ceneo_export] <?php print $checked_ceneo_export;?> value=1><?php print $lang->edit_ceneo['ceneo_export'];?>
  </td>
</tr>

<tr>	
  <td align="center"><?php $buttons->button($lang->edit_edit_submit,"javascript:document.editForm.submit();");?></td>
</tr>	
</table>

<?php
$theme->desktop_close();
}
?>
<!-- pasaz.ceneo.pl -->
