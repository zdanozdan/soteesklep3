<?php
/**
* Formularz do wprowadzania opisu produktu
* 
* @author  m@sote.pl
* @version $Id: edit_page_description.html.php,v 2.8 2005/03/11 14:42:16 lechu Exp $
* @package admin
* @subpackage edit
*
* @verified 2004-03-15 m@sote.pl
* \@lang
*/
?>
<?php $theme->choose_lang("description_lang.php",$rec->data['id'],"lang_id");?>
<?php $theme->desktop_open("100%");?>

<form action=description_lang.php method=post enctype=multipart/form-data>

<input type=hidden name=id value='<?php print $rec->data['id'];?>'>
<input type=hidden name=user_id value='<?php print $rec->data['user_id'];?>'>
<input type=hidden name=update value=true>
<input type=hidden name=item[lang_id] value='<?php print $rec->data['lang_id'];?>'>

<table width=100%>
<tr>
  <?php print $lang->cols['name'];?> <input type=text size=32 name=item[name] value='<?php print $rec->data['name'];?>'>
</tr>
<tr>
  <td valign=top width=100%>
    <input type=file name=file_xml_description size=10 align=center> <?php print $lang->upload_file;?> HTML, TXT, XML
    <input type=submit value='<?php print $lang->edit_submit;?>'><br>
    <textarea rows=18 cols=120 name=item[xml_description] id=item[xml_description]><?php print $rec->data['xml_description'];?></textarea>
    <?php print "<a href='javascript:void(0)' onclick='window.open(\"/go/_text/forms_wysiwyg.php?textareaname=item[xml_description]&action=open_window\", \"wysiwyg\", \"menubar=0, tootlbar=0, width=800, height=600\")'>" . $lang->wysiwyg_button . "</a>"; ?>
  </td>
</tr>
<tr>
  <td valign=top width=100%>
   <input type=file name=file_xml_short_description size=10 align=center> <?php print $lang->upload_file;?> HTML, TXT, XML
   <input type=submit value='<?php print $lang->edit_submit;?>'><br>
   <textarea rows=6 cols=120 name=item[xml_short_description] id=item[xml_short_description]><?php print $rec->data['xml_short_description'];?></textarea> 
   <?php print "<a href='javascript:void(0)' onclick='window.open(\"/go/_text/forms_wysiwyg.php?textareaname=item[xml_short_description]&action=open_window\", \"wysiwyg\", \"menubar=0, tootlbar=0, width=800, height=600\")'>" . $lang->wysiwyg_button . "</a>"; ?>
  </td>
</tr>
</table>

</form>

<?php $theme->desktop_close();?>