<?php
/**
* Szablon prezentujacy dane poszczegolnej waluty.
*
* 
* @version $Id: currency_edit.html.php,v 2.6 2005/04/01 10:29:18 maroslaw Exp $
* 
* @package    currency
*/

// dla edycji, nie zezwalaj na edytowanie ID
global $__edit;
if (($__edit) || (! empty($_REQUEST['update']))) {
    $disable_id="disabled";
} else {
    $disable_id='';    
}

if (empty($rec->data['id'])) {
    require_once ("include/next_id.inc.php");
    $rec->data['id']=NextID::next("currency");
}
?>

<form action=<?php print $action;?> method=POST>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$this->id;?>> 
<p>

<?php
$onclick="onclick=\"window.open('','window1','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<table align=center>
<tr>
   <td><?php print $lang->currency_cols['id']?></td>
   <td><input type=text size=10 name=item[id] value="<?php print @$rec->data['id'];?>" <?php print $disable_id;?>><br>
   <?php
   if ($disable_id) {
       print "<input type=hidden name=item[id] value=".$rec->data['id'].">\n";
   }
   ?>   
   </td>
</tr>

<tr>
   <td><?php print $lang->currency_cols['currency_name']?></td>
   <td><input type=text size=10 name=item[currency_name] value="<?php print @$rec->data['currency_name'];?>"><br>
   <?php $theme->form_error('currency_name');?>
   </td>
</tr>

<tr>
   <td><?php print $lang->currency_cols['currency_val']?></td>
   <td><input type=text size=10 name=item[currency_val] value="<?php print @$rec->data['currency_val'];?>"><br>
   <?php $theme->form_error('currency_val');?>
   </td>
</tr>

<tr>
 <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>

</table>

</form>
