<?php
/**
* Formularz edycji newsa.
*
* @author  m@sote.pl lech@sote.pl
* @version $Id: newsedit_edit.html.php,v 2.17 2005/03/14 14:06:30 lechu Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
* \@lang
*/

define ("NEWSEDIT_MAX_MULTI_GROUPS",3);  // maksymalna liczba grup typu: multi

/*
* Import sta³ych
*/
include_once ("WYSIWYG/wysiwyg.inc.php");

if (@$rec->data['active']==1) {
    $active_checked="checked";
} else {
    $active_checked='';
}

if (@$rec->data['main_page']==1) {
    $main_page_checked="checked";
} else {
    $main_page_checked='';
}


if (@$rec->data['rss']==1) {
    $rss_checked="checked";
} else {
    $rss_checked='';
}


global $global_id;
global $buttons;
?>

<form action=<?php print $action;?> method=post enctype="multipart/form-data" name=newseditForm>
<input type=hidden name=update value=true>
<input type=hidden name=id value=<?php print @$global_id;?>> 
<p>

<?php
global $__edit,$config;
if (empty($global_id)) {
    print $lang->newsedit_lang_info."<br>";
    foreach ($config->langs_symbols as $lang_key=>$lang_symbol) {
        if($config->langs_active[$lang_key]) {
            $lang_name = $config->langs_names[$lang_key];
            if ($lang_key==$config->lang_id) $checked="checked"; else $checked='';
            print "<input type=radio name=newsedit[lang] value='$lang_symbol' $checked>$lang_name</input>\n";
        }
    }
}
?>

<?php
$onclick="onclick=\"window.open('','window1','width=760,height=580,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>

<table align=center border="0">

<?php
if (! empty($id)) {
?>
<tr>
   <td><?php print $lang->newsedit_cols['id']?></td>
   <td>
     <table width=100%><tr>
       <td align=left><?php print "<b>$id</b>";?></td>
       <td align=right><?php $buttons->button($lang->save,"\"javascript:document.newseditForm.submit();\"");?></td>
     </tr></table>
   </td>
</tr>
<?php
} else {
?>
<tr>
   <td></td>
   <td>
     <table width=100%><tr>
       <td align=left></td>
       <td align=right><?php $buttons->button($lang->save,"\"javascript:document.newseditForm.submit();\"");?></td>
     </tr></table>
   </td>
</tr>
<?php
}
?>

<tr>
  <td><?php print $lang->newsedit_cols['id_newsedit_groups'];?></td>
  <td>
     <?php    
     require_once ("MetabaseData/DataForm.php");
     // jesli nie ma przypisanej grupy (np. przy dodawaniu produktu) to zaznacz
     // domyslnie wybrana grupe, ktora jest prezentowana na liscie newsow
     if (empty($rec->data['id_newsedit_groups'])) {
         $rec->data['id_newsedit_groups']=@$__newsedit_group['id'];
     }
     $data=$mdbd->select("id,name","newsedit_groups","1",array(),"","ARRAY");
     $form = new DataForm($mdbd,"/plugins/_newsedit/index.php","POST","newseditGroupForm");
     $form->default_select='';
     $form->dbMemSelect($data,"newsedit[id_newsedit_groups]",$lang->newsedit_groups_select,$rec->data['id_newsedit_groups']);
     $form->dbMemDisplaySelect("newsedit[id_newsedit_groups]");
     ?>
  </td>
</tr>

<?php
$data=$mdbd->select("id,name","newsedit_groups","multi=1",array(),"","ARRAY");

if (! empty($data)) {
?>
<tr>
  <td><?php print $lang->newsedit_cols['multi_groups'];?></td>
  <td>
    <?php
    reset($data);$i=1;
    foreach ($data as $group) {
        $group_id=$group['id'];
        $group_name=$group['name'];
                
        $value=@$rec->data["group$i"];
        if ($value>0) $checked=" checked"; else $checked='';               
        if ($i<=NEWSEDIT_MAX_MULTI_GROUPS) {
            print "<input type=checkbox name=newsedit[group$i] value='".@$group_id."'$checked>$group_name\n";
        }
        $i++;
    } // end foreach
    ?>
  </td>
</tr>
<?php
}
?>
<tr>
   <td><?php print $lang->newsedit_cols['rss']?></td>
   <td><input type=checkbox name=newsedit[rss] value="1" <?php echo $rss_checked; ?>> - <a href="javascript:void(0)" onclick='window.open("/plugins/_help_content/help_show.php?id=42", "help", "menubar=0, tootlbar=0, width=300, height=500, resizable=1, scrollbars=1")'><? echo $lang->help; ?></a><br>
   </td>
</tr>

<tr>
   <td><?php print $lang->newsedit_cols['date_add']?></td>
   <td><input type=data name=newsedit[date_add] value="<?php print date("Y-m-d");?>"><br>
<?php $theme->form_error('date_add');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->newsedit_cols['active']?></td>
   <td>
    <input type=checkbox name=newsedit[active] value=1 <?php print $active_checked;?>>
    <br>    
   </td>
</tr>

<!-- Tu jest kod, ktory jest tylko prezentacja formularza HTML, element wersji 2.1 do napisania-->
<!--<tr>
   <td><?php print $lang->newsedit_cols['group'];?></td>
   <td>
      <select namer=newsedit[group]>
       <option value=1>nowosci</option>
       <option value=2>faq</option>
       <option value=3>promocje</option>
      </select>
   </td>
</tr>-->
<!-- end -->


<tr>
   <td><?php print $lang->newsedit_cols['ordercol']?></td>
   <td><input type=text size=5 name=newsedit[ordercol] value="<?php print @$rec->data['ordercol'];?>"><br>
<?php $theme->form_error('ordercol');?>
   </td>
</tr>
<tr>
   <td><b><?php print $lang->newsedit_cols['subject']?></b></td>
   <td><input type=text size=50 name=newsedit[subject] value="<?php print @$rec->data['subject'];?>"><br>
<?php $theme->form_error('subject');?>
   </td>
</tr>

<tr>
  <td><?php print $lang->newsedit_cols['url_auto'];?></td>
  <td>
    <?php
    if ((empty($rec->data['url'])) && (! empty($id))) {
        print "/plugins/_newsedit/$id/index.php<BR>";
    }
    ?>
  </td>
</tr>
<tr>
   <td><?php print $lang->newsedit_cols['url']?></td>
   <td>
    <input type=text size=50 name=newsedit[url] value="<?php print @$rec->data['url'];?>"><br>
    <?php $theme->form_error('url');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->newsedit_cols['category']?></td>
   <td><input type=text size=30 name=newsedit[category] value="<?php print @$rec->data['category'];?>"><br>
<?php $theme->form_error('category');?>
   </td>
</tr>
<tr>
   <td><?php print $lang->newsedit_cols['short_description']?></td>
   <td><textarea name=newsedit[short_description] id=newsedit[short_description] cols=80 rows=3 wrap=virtual><?php print @$rec->data['short_description'];?></textarea><br>
   <?php
/*
Dodanie mo¿liwo¶ci edycji WYSIWYG

    1. W znaczniku textarea musi znale¼æ siê atrybut id o warto¶ci najlepiej tej samej co name.
    2. Dodaæ poni¿szy kod, pierwszy parametr ma przyj±æ warto¶æ id edytowanego textarea.
       Drugi - WYSIWYG_ENABLED (link zostanie wygenerowany) lub WYSIWYG_DISABLED
       (link nie zostanie wygenerowany).
*/
    $theme->wysiwygTextarea("newsedit[short_description]", WYSIWYG_ENABLED);
/*
Dodanie mo¿liwo¶ci edycji WYSIWYG - koniec
*/
   ?>
   <?php $theme->form_error('short_description');?>
   </td>
</tr>

<!-- tresc newsa -->
<tr bgcolor=<?php print $theme->bg_bar_color_light;?>>
   <td><?php print $lang->newsedit_cols['description']?></td>
   <td><textarea name=newsedit[description] id=newsedit[description] cols=80 rows=15 wrap=virtual><?php print @$rec->data['description'];?></textarea><br>
   <?php
/*
Dodanie mo¿liwo¶ci edycji WYSIWYG

    1. W znaczniku textarea musi znale¼æ siê atrybut id o warto¶ci najlepiej tej samej co name.
    2. Dodaæ poni¿szy kod, pierwszy parametr ma przyj±æ warto¶æ id edytowanego textarea.
       Drugi - WYSIWYG_ENABLED (link zostanie wygenerowany) lub WYSIWYG_DISABLED
       (link nie zostanie wygenerowany).
*/
    $theme->wysiwygTextarea("newsedit[description]", WYSIWYG_ENABLED);
/*
Dodanie mo¿liwo¶ci edycji WYSIWYG - koniec
*/
   ?>
   <?php $theme->form_error('description');?>
   </td>
</tr>

<!-- start zalacz tresc newsa w postaci pliku html -->
<tr bgcolor=<?php print $theme->bg_bar_color_light;?>>
   <td><?php print $lang->newsedit_cols['desc_file']?></td>
   <td><input type=file  name=newsedit[desc_file] value="<?php print @$rec->data['desc_file'];?>">
   <a href="<?php print "http://" . $config->www . "/plugins/_newsedit/news/$global_id/".@$rec->data['desc_file'];?>" <?php print $onclick; ?> target=window1><?php print @$rec->data['desc_file'];?></a> 
   <?php  if (! empty($rec->data['desc_file'])) {       
       print "<input type=hidden name=photo[desc_file] value='".@$rec->data["desc_file"]."'>\n";
       //print "<input type=checkbox name=del[desc_file] value=1>$lang->delete";
   } ?>
    <?php $theme->form_error('desc_file');?>
   </td>
</tr>
<!-- end -->
<!-- end tresc newsa -->

<tr>
   <td><?php print $lang->newsedit_cols['photo_small']?></td>
   <td><input type=file  name=newsedit[photo_small] value="<?php print @$rec->data['photo_small'];?>">
   <a href="<?php print "http://" . $config->www . "/plugins/_newsedit/news/$global_id/".@$rec->data['photo_small'];?>" <?php print $onclick; ?> target=window1><?php print @$rec->data['photo_small'];?></a> 
   <?php  if (! empty($rec->data['photo_small'])) {  
       $name_photo=$rec->data['photo_small'];
       print "<input type=hidden name=photo[photo_small] value='".@$name_photo."'>\n";
       print"<a href=\"/plugins/_newsedit/edit.php?id=$id&action=delete_photo&photo_name=$name_photo&type=small\">&nbsp;&nbsp;<B>[".$lang->delete."]</B></a>";
     }
     ?>
    <?php $theme->form_error('photo_small');?>
   
    </td>
</tr>


<?php
for ($i=1;$i<=8;$i++) {
?>
<tr>
   <td><?php print $lang->newsedit_cols["photo$i"]?></td>
   <td><input type=file  name=newsedit[<?php print "photo$i";?>]>
   <?php  
   if (! empty($rec->data["photo$i"])) {
       print "<input type=hidden name=photo[photo$i] value='".@$rec->data["photo$i"]."'>\n";
       $name_photo=$rec->data["photo$i"];
       print "<a href='http://" . $config->www . "/plugins/_newsedit/news/$global_id/".@$rec->data["photo$i"]."' $onclick target=window1>".@$name_photo."</a>\n";
       print"<a href=\"/plugins/_newsedit/edit.php?id=$id&action=delete_photo&photo_name=$name_photo&type=big$i\">&nbsp;&nbsp;<B>[".$lang->delete."]</B></a>";
   }
    ?>
  
  </td>
</tr>
<?php
}
?>

<tr>
  <td></td>
  <td align=right><?php $buttons->button($lang->save,"\"javascript:document.newseditForm.submit();\"");?></td>
</tr>

</table>

</form>
