<?php
/**
* Edycja opcji zwi±zanych z pasaz.ceneo.pl
*
* @author  rdiak@sote.pl
* @version $Id: edit_ceneo.html.php,v 2.2 2006/01/10 12:12:09 scalak Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/
?>
<!-- pasaz.ceneo.pl -->
<?php 
global $action;
global $DOCUMENT_ROOT;

$id=@$_REQUEST['id'];
if (in_array("ceneo.pl",$config->plugins)) {
    // ceneo_export
	if (@$rec->data['ceneo_export']=="0") {
    	$checked_ceneo_export="";
    } else {
    	$checked_ceneo_export="checked";
    }

    if (@$rec->data['ceneo_attrib']=="1") {
    	$checked_ceneo_attrib="checked";
    } else {
    	$checked_ceneo_attrib="";
    }

    
    
    
    $theme->desktop_open();
?>
<form action=<?php print @$action;?> method=post name=editForm  enctype=multipart/form-data>
<input type=hidden name=user_id value='<?php print @$_REQUEST['user_id'];?>'>
<input type=hidden name=update value=true>

<table>
<tr>
  <td><?php print $lang->edit_ceneo_head; ?></td>
</tr>

<tr>
  <td>
    <input type=checkbox name=item[ceneo_export] <?php print $checked_ceneo_export;?> value=1><?php print $lang->edit_ceneo['ceneo_export'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>

<tr>
  <td>
    <input type=checkbox name=item[ceneo_attrib] <?php print $checked_ceneo_attrib;?> value=1><?php print $lang->edit_ceneo['ceneo_attrib'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>

<?php
    global $ceneo_config;
    if(in_array("Ksi±¿ki",$ceneo_config->ceneo_category)) {
        include_once("ceneo_books.html.php");
    }
    if(in_array("Felgi",$ceneo_config->ceneo_category)) {
        include_once("ceneo_felgi.html.php");
    }
    if(in_array("Filmy",$ceneo_config->ceneo_category)) {
        include_once("ceneo_filmy.html.php");
    }
    if(in_array("Opony",$ceneo_config->ceneo_category)) {
        include_once("ceneo_opony.html.php");
    }
    if(in_array("Perfumy",$ceneo_config->ceneo_category)) {
        include_once("ceneo_perfumy.html.php");
    }
?>







<tr>	
  <td><?php $buttons->button($lang->edit_edit_submit,"javascript:document.editForm.submit();");?></td>
</tr>	
</table>

<?php
$theme->desktop_close();
}
?>
<!-- pasaz.ceneo.pl -->
