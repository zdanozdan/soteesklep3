<?php
/**
* Edycja opcji zaawansowanych produktu
*
* @author  m@sote.pl
* @version $Id: edit_xml_options.html.php,v 2.3 2004/12/20 17:58:00 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/
?>
<form action=edit_xml_options_preview.php method=post enctype=multipart/form-data target=preview>
<input type=hidden name=id value='<?php print $rec->data['id'];?>'>
<input type=hidden name=update value=true>

<div align=right>
<input type=submit value='<?php print $lang->edit_submit;?>'>
</div>

<table width=100%>
<tr>
  <td valign=top width=100%>
    <textarea rows=28 cols=52 name=item[xml_options2]><?php print $rec->data['xml_options2'];?></textarea> 
  </td>
</tr>
</table>

<div align=right>
<input type=submit value='<?php print $lang->edit_submit;?>'>
</div>

</form>
