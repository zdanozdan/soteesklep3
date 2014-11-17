<?php
/**
* Edycja opcji zwi±zanych z pasaz.onet.pl
*
* @author  rdiak@sote.pl
* @version $Id: edit_onet.html.php,v 2.11 2006/01/12 11:36:21 scalak Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/
?>
<!-- pasaz.onet.pl -->
<?php 
global $action;
global $DOCUMENT_ROOT;
if (in_array("pasaz.onet.pl",$config->plugins)) {
    if (@$rec->data['onet_export']==0) $checked_onet_export=""; else $checked_onet_export="checked";
    if (@$rec->data['onet_image_export']==0) $checked_onet_image_export=""; else $checked_onet_image_export="checked";
    if (@$rec->data['onet_status']==1) {
        $checked_onet_status1="checked";
    } elseif( @$rec->data['onet_status']==0) {
         $checked_onet_status2="checked";
    } else $checked_onet_status1="checked";
    
    $theme->desktop_open();
    
    $file_name=$DOCUMENT_ROOT."/plugins/_pasaz.onet.pl/file/onet_category_cut.php";
    if(! file_exists($file_name)) {
    	print $lang->edit_onet['onet_not_file'];
        $theme->desktop_close();
        exit;
    }

    if (@$rec->data['onet_op']=="0") {
       $checked_onet_op1="selected"; 
    } elseif(@$rec->data['onet_op']=="1") {
       $checked_onet_op2="selected"; 
    } elseif(@$rec->data['onet_op']=="2") {
       $checked_onet_op3="selected"; 
    } else {
       $checked_onet_op1="selected"; 
    }   
 ?>
<form action=<?php print @$action;?> method=post name=editForm  enctype=multipart/form-data>
<input type=hidden name=id value='<?php print @$_REQUEST['id'];?>'>
<input type=hidden name=update value=true>

<table>
<tr>
  <td><?php print $lang->edit_onet_head; ?></td>
</tr>
<tr>
  <td>
    <input type=checkbox name=item[onet_export] <?php print $checked_onet_export;?> value=1><?php print $lang->edit_onet['onet_export'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>
<tr>
  <td>
    <input type=radio name=item[onet_status] <?php print @$checked_onet_status1;?> value=1 ><?php print $lang->edit_onet['onet_status_update'];?>&nbsp;&nbsp;&nbsp;
	<input type=radio name=item[onet_status] <?php print @$checked_onet_status2;?> value=0><?php print $lang->edit_onet['onet_status_delete'];?>
  </td>
</tr>
<tr>
  <td>
    <input type=checkbox name=item[onet_image_export] <?php print $checked_onet_image_export;?> value=1><?php print $lang->edit_onet['onet_image_export'];?>
  </td>
</tr>
<tr>
  <td>
    <?php print $lang->edit_onet['onet_image_title'];?> &nbsp;&nbsp;&nbsp; <input type=text name=item[onet_image_title] size=30 value="<?php print @$rec->data['onet_image_title'];?>">
  </td>
</tr>
<!-- new onew
<tr>
  <td>
    <?php /* print  $lang->edit_onet['onet_op'];?> &nbsp;&nbsp;&nbsp; 
  	<select name="item[onet_op]">
    <option value="0" <?php print @$checked_onet_op1; ?>>nie wy¶wietlana</OPTION>
    <option value="1" <?php print @$checked_onet_op2; ?>>wy¶wietlana</OPTION>
    <option value="2" <?php print @$checked_onet_op3; ?>>wy¶wietlana czêsto</OPTION>
  	</select>
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_onet['onet_author'];?> &nbsp;&nbsp;&nbsp; <input type=text name=item[onet_author] size=30 value="<?php print @$rec->data['onet_author'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_onet['onet_edition']; ?> &nbsp;&nbsp;&nbsp; <input type=text name=item[onet_edition] size=30 value="<?php print @$rec->data['onet_edition'];*/ ?>">
  </td>
</tr>
-->
<tr>
  <td>
    <?php print $lang->edit_onet['onet_image_desc'];?> &nbsp;&nbsp;&nbsp; <input type=text name=item[onet_image_desc] size=30 value="<?php print @$rec->data['onet_image_desc'];?>">
  </td>
</tr>
<tr>
  <td>
    <?php print $lang->edit_onet['onet_attrib'];?> &nbsp;&nbsp;&nbsp; <input type=text name=item[onet_attrib] size=30 value="<?php print @$rec->data['onet_attrib'];?>">
  </td>
</tr>

<tr>
  <td>
	<?php
	print $lang->edit_onet['onet_category']."&nbsp;&nbsp;";
	$data=file($file_name,1);
	if(empty($rec->data['onet_category']) || $rec->data['onet_category']=='opt') {
	    $tmp="";
	} else {
	    $tmp=$rec->data['onet_category'];
	}
	while(list($line_num,$line)=each($data)){
	    if (@strstr($line,$tmp)) {
	        $line=str_replace("<option","<option selected",$line);
	    }
	    print $line;
	}
	?>
  </td>
</tr>	

<tr>
  <td><input type=checkbox name=item[onet_same_cat]  value=1><?php print $lang->edit_onet['onet_same_cat'];?>&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr>	
  <td></td>
  <td><?php $buttons->button($lang->edit_edit_submit,"javascript:document.editForm.submit();");?></td>
</tr>	
</table>

<?php
$theme->desktop_close();
}
?>
<!-- pasaz.onet.pl -->
