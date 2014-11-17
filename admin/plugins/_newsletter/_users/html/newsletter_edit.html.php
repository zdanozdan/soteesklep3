<?php
/**
* Formularz edycji adresu e-mail.
*
* Defainiowanie przynale¿no¶ci do grup.
*
* @author  rdiak@sote.pl
* @version $Id: newsletter_edit.html.php,v 2.14 2006/03/01 10:31:03 lechu Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

global $table;

if(empty($rec->data['status'])) {
    if (@$rec->data['status'] == '0') {
        $status_yes="";
        $status_no="selected";
    } else {
        $status_yes="selected";
        $status_no="";
    }
} else {
    $status_yes="selected";
    $status_no="";
}

if(! empty($rec->data['groups'])) {
    $tabs=split(":",$rec->data['groups']);
} else {
    $tabs=array();
}


?>
<form action=<?php print $action;?> method=POST>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$this->id;?>> 
<input type=hidden name=item[active] value=1>
<p>

<?php
$onclick="onclick=\"window.open('','window1','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<center>
<?php $theme->desktop_open("350"); ?>
<table align=center>
<tr>
  <td><?php print $lang->newsletter_cols['email']?></td>
  <td><input type=text size=30 name=item[email] value="<?php print @$rec->data['email'];?>"><br>
   <?php $theme->form_error('email');?>
  </td>
</tr>

<tr>
  <td><?php print $lang->newsletter_cols['active']?></td>
  <td>
    <select name=item[status]>
     <option value=1 <?php print $status_yes;?>><?php print $lang->bool["1"];?>
     <option value=0 <?php print $status_no;?>><?php print $lang->bool["0"];?>
    </select>
  </td>
</tr>

<tr>
  <td><?php print $lang->newsletter_cols['groups']?></td>
  <td>
    <?php 
    $i=0; foreach ($table as $key => $value) {
        $check='';
        if(in_array($key,$tabs)){
            $check="checked";
        }
        if($value == 'public') {
            $check="checked";
        }
    ?>
    <input type=checkbox name=groups[<?php print $i;?>] value=<?php print $key;?> <?php print $check;?>> <?php print $value;?> <br>    
    <?php $i++;}?>
  </td>
</tr>
<tr>
  <td><?php print $lang->newsletter_cols['lang'];?>
  <td>
      <?php
      // wybór jêzyka
      global $config;
      print "<p>".$lang->newsletter_lang_select_info."<BR>";
      print "<select name=item[lang]>\n";
      foreach ($config->langs_names as $lang_key=>$lang_name) {
          if ($config->langs_symbols[$lang_key] == $rec->data['lang']) $selected="selected"; else $selected='';
          print "<option value='".$config->langs_symbols[$lang_key]."' $selected>$lang_name</option>\n";
      }
      print "</select>\n";
      ?>      
  </td>
</tr>
<tr>
  <td></td><td><input type=submit value="<?php print $lang->edit_submit;?>">
</tr>

</table>

<?php $theme->desktop_close(); ?>
</form>
