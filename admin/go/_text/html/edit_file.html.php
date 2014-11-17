<?php
/**
* @version    $Id: edit_file.html.php,v 2.5 2004/12/20 17:59:06 maroslaw Exp $
* @package    text
*/
?>
<form action=edit_preview.php method=post target=preview>
<input type=hidden name=update value=true>
<input type=hidden name=file value="<?php print @$file;?>">
<input type=hidden name=file_name value="<?php print @$file_name;?>">
<input type=hidden name=lang_name value="<?php print @$lang_name;?>">
<table wisth=100%>
<tr>
  <td width=50% valign=top>

<?php
if (empty($filedev)) {
    print $lang->text_title;
    print "<input type=text name=title size=30 value='".@$title."'>\n";
    print "<textarea name=file_source rows=31 cols=46>$file_source</textarea>\n";
} else {    
    print "<input type=hidden name=filedev value=\"$filedev\">\n";
    print "<textarea name=file_source rows=31 cols=128>$file_source</textarea>\n"; 
}
?>

  </td>
</tr>
<tr><td align=center><input type=submit value="<?php print $lang->edit_submit;?>"></td></tr>
</table>
</form>
