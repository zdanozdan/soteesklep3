<?php
/**
* Edycja opcji zwi±zanych z pasaz.wp.pl
*
* @author  rdiak@sote.pl
* @version $Id: edit_wp.html.php,v 2.7 2006/01/04 13:27:01 scalak Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/
?>
<!-- pasaz.wp.pl -->
<?php 
global $action;
global $DOCUMENT_ROOT;

$id=@$_REQUEST['id'];
if (in_array("pasaz.wp.pl",$config->plugins)) {
    // wp_export
	if (@$rec->data['wp_export']=="1") {
    	$checked_wp_export="checked";
    } else {
    	$checked_wp_export="";
    }
	// wp_status
    if (@$rec->data['wp_status']=="1") {
        $checked_wp_status1="checked";
    } elseif(@$rec->data['wp_status']=="2") {
        $checked_wp_status2="checked";
    } elseif(@$rec->data['wp_status']=="3") {
    	$checked_wp_status3="checked";
    } else {
     	$checked_wp_status1="checked";
    }
	
    // wp_ptg
    if (@$rec->data['wp_ptg']=="1") {
    	$checked_wp_ptg="checked";
    } else {
    	$checked_wp_ptg="";
    }

    
    
    $theme->desktop_open();
    
    $file_name=$DOCUMENT_ROOT."/plugins/_pasaz.wp.pl/file/wp_category_cut.php";
    $file_name_producer=$DOCUMENT_ROOT."/plugins/_pasaz.wp.pl/file/wp_producer.php";
    if(! file_exists($file_name)) {
    	print $lang->edit_wp['wp_not_file'];
        $theme->desktop_close();
        exit;
    }
?>
<form action=<?php print @$action;?> method=post name=editForm  enctype=multipart/form-data>
<input type=hidden name=user_id value='<?php print @$_REQUEST['user_id'];?>'>
<input type=hidden name=update value=true>

<table>
<tr>
  <td><?php print $lang->edit_wp_head; ?></td>
</tr>

<tr>
  <td>
    <input type=checkbox name=item[wp_export] <?php print $checked_wp_export;?> value=1><?php print $lang->edit_wp['wp_export'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>


<tr>
  <td>
    <input type=radio name=item[wp_status] <?php print @$checked_wp_status1;?> value=1 ><?php print $lang->edit_wp['wp_status_add'];?>&nbsp;&nbsp;&nbsp;
	<input type=radio name=item[wp_status] <?php print @$checked_wp_status2;?> value=2><?php print $lang->edit_wp['wp_status_update'];?>&nbsp;&nbsp;&nbsp;
	<input type=radio name=item[wp_status] <?php print @$checked_wp_status3;?> value=3><?php print $lang->edit_wp['wp_status_delete'];?>
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_wp['wp_dictid'];?> &nbsp;&nbsp;&nbsp; <input type=text name=item[wp_dictid] size=30 value="<?php print @$rec->data['wp_dictid'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_wp['wp_valid'];
    $manage_date=& new DateManage;
	$manage_date->count=1;
	$manage_date->lang='pl';
	$manage_date->ShowDateManageOne($_REQUEST['user_id'],1);
	?>
  </td>
</tr>




<tr>
  <td>
	<?php
	print $lang->edit_wp['wp_category']."&nbsp;&nbsp;";
	$data=file($file_name,1);
	if(empty($rec->data['wp_category'])) {
	    $tmp=$lang->edit_wp_select;
	} else {
	    $tmp=$rec->data['wp_category'];
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
  <td>
	<?php
	print $lang->edit_wp['wp_producer']."&nbsp;&nbsp;";
	$data=file($file_name_producer,1);
	if(empty($rec->data['wp_producer'])) {
	    $tmp=$lang->edit_wp_select;
	} else {
	    $tmp=$rec->data['wp_producer'];
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
  <td>
	<?php
	print $lang->edit_wp['wp_fields']."&nbsp;&nbsp;";
	$str=$database->sql_select_select1("wp_fields","item[wp_fields]","cid","field1","field2",@$rec->data['wp_fields']," ORDER BY field1 ","opt=----wybierz----");
	print $str;
	?>
  </td>
</tr>	



<tr>
  <td>
	<?php
	print $lang->edit_wp['wp_dest']."&nbsp;&nbsp;";
	?>
	<select name="item[wp_dest]">
	<?php foreach($lang->edit_wp_dest as $key=>$value) {
		if($key == $rec->data['wp_dest']) {
			print "<option value=\"".$key."\" selected>".$value."</OPTION>";
		} else {
			print "<option value=\"".$key."\">".$value."</OPTION>";
		}
	}
	?>	
	</select>
  </td>
</tr>	

<tr>
  <td>
	<table><tr><td>
  <?php
	print $lang->edit_wp['wp_advantages']."&nbsp;&nbsp;";?>
	</td><td>
	<?php
	$select_adv=split(",",@$rec->data['wp_advantages']);
	$str=$database->sql_select_multiple("wp_advant","item[wp_advantages][]","aid","name","","","opt=----wybierz----",4,$select_adv);
	print $str;
	?>
	</td></tr></table>
	</td>
</tr>	

<tr>
  <td>
	<table><tr><td>
  <?php
	print $lang->edit_wp['wp_filters']."&nbsp;&nbsp;";?>
	</td>
	<td><?php
	$select_fil=split(",",@$rec->data['wp_filters']);
	$str=$database->sql_select_multiple1("wp_filters","item[wp_filters][]","lfid","lfname","lfvalue","","","opt=----wybierz----",4,$select_fil);
	//$str=$database->sql_select_select1("wp_filters","item[wp_filters]","lfid","lfname","lfvalue",@$rec->data['wp_filters']," ORDER BY lfname ","opt=----wybierz----");
	print $str;
	?>
	</td></tr></table>
	</td>
</tr>	

<tr>
  <td>
    <input type=checkbox name=item[wp_ptg] <?php print $checked_wp_ptg;?> value=1><?php print $lang->edit_wp['wp_ptg'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>

<tr>
  <td>
	<?php print $lang->edit_wp['wp_ptg_desc'];?>&nbsp;&nbsp;<TEXTAREA name="item[wp_ptg_desc]" rows="3" cols="30"><?php print @$rec->data['wp_ptg_desc']; ?></TEXTAREA> 
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_wp['wp_ptg_days'];?> &nbsp;&nbsp;&nbsp; <input type=text name=item[wp_ptg_days] size=10 value="<?php print @$rec->data['wp_ptg_days'];?>">
  </td>
</tr>

<tr>
  <td>
    <?php print $lang->edit_wp['wp_ptg_picurl'];?> &nbsp;&nbsp;&nbsp; <input type=text name=item[wp_ptg_picurl] size=30 value="<?php print @$rec->data['wp_ptg_picurl'];?>">
  </td>
</tr>
<tr>
  <td>
    &nbsp;
  </td>
</tr>

<tr>
  <td>
  <select name=item[wp_same_cat1]>
  <OPTION value="1">Kategoria 1</OPTION>
  <OPTION value="2">Kategoria 2</OPTION>
  <OPTION value="3">Kategoria 3</OPTION>
  <OPTION value="4">Kategoria 4</OPTION>
  <OPTION value="5">Kategoria 5</OPTION>
  </select>
  <input type=checkbox name=item[wp_same_cat]  value=1><?php print $lang->edit_wp['wp_same_cat'];?>&nbsp;&nbsp;&nbsp;
  </td>
</tr>

<tr>
  <td>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type=checkbox name=item[wp_same_prod]  value=1><?php print $lang->edit_wp['wp_same_prod'];?>&nbsp;&nbsp;&nbsp;
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
<!-- pasaz.wp.pl -->
