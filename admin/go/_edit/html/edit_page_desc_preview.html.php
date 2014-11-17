<?php
/**
* Podgl±d opisu produktu.
*
* @author  m@sote.pl
* @version $Id: edit_page_desc_preview.html.php,v 2.2 2004/03/15 14:53:26 maroslaw Exp $
* @package admin
* @subpackage edit
*
* @verified 2004-03-15 m@sote.pl
*/
?>
<table width=100%>
<tr>
  <td valign=top width=100%>
   <b><?php print $lang->cols['xml_description'];?>:</b><br>
   <?php print $rec->data['xml_description'];?><br>
  </td>
</tr>
<tr>
  <td valign=top width=100%>
   <b><?php print $lang->cols['xml_short_description'];?>:</b><br>
   <?php print $rec->data['xml_short_description'];?><br>
  </td>
</tr>
</table>

