<?php
/**
* Edycja opcji zwi±zanych z pasaz.interia.pl
*
* @author  rdiak@sote.pl
* @version $Id: edit_interia.html.php,v 2.2 2006/01/04 13:27:04 scalak Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/
?>
<!-- pasaz.interia.pl -->
<?php 
global $action;
global $DOCUMENT_ROOT;

$id=@$_REQUEST['id'];
if (in_array("pasaz.interia.pl",$config->plugins)) {
    // interia_export
	if (@$rec->data['interia_export']=="1") {
    	$checked_interia_export="checked";
    } else {
    	$checked_interia_export="";
    }
	// interia_status
    if (@$rec->data['interia_status']=="1") {
        $checked_interia_status1="checked";
    } elseif(@$rec->data['interia_status']=="2") {
        $checked_interia_status2="checked";
    } elseif(@$rec->data['interia_status']=="3") {
    	$checked_interia_status3="checked";
    } else {
     	$checked_interia_status1="checked";
    }
	
    // interia_ptg
    if (@$rec->data['interia_ptg']=="1") {
    	$checked_interia_ptg="checked";
    } else {
    	$checked_interia_ptg="";
    }

    
    
    $theme->desktop_open();

    $file_name=$DOCUMENT_ROOT."/plugins/_pasaz.interia.pl/file/interia_category_cut.php";
    if(! file_exists($file_name)) {
    	print $lang->edit_interia['interia_not_file'];
        $theme->desktop_close();
        exit;
    }
   
?>
<form action=<?php print @$action;?> method=post name=editForm  enctype=multipart/form-data>
<input type=hidden name=user_id value='<?php print @$_REQUEST['user_id'];?>'>
<input type=hidden name=update value=true>

<table>
<tr>
  <td><?php print $lang->edit_interia_head; ?></td>
</tr>

<tr>
  <td>
    <input type=checkbox name=item[interia_export] <?php print $checked_interia_export;?> value=1><?php print $lang->edit_interia['interia_export'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>


<tr>
  <td>
    <input type=radio name=item[interia_status] <?php print @$checked_interia_status1;?> value=1 ><?php print $lang->edit_interia['interia_status_add'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>

<tr>
  <td>
	<?php
	print $lang->edit_interia['interia_category']."&nbsp;&nbsp;";
	$data=file($file_name,1);
	if(empty($rec->data['interia_category'])) {
	    $tmp=$lang->edit_interia_select;
	} else {
	    $tmp=$rec->data['interia_category'];
	}
	while(list($line_num,$line)=each($data)){
	    if (strstr($line,$tmp)) {
	        $line=str_replace("<option","<option selected",$line);
	    }
	    print $line;
	}
	?>
  </td>
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
<!-- pasaz.interia.pl -->
