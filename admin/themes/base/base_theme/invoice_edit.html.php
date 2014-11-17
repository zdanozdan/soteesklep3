<?php
/**
* @version    $Id: invoice_edit.html.php,v 1.2 2004/12/20 18:01:21 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<table align=center border=0 width=460 cellspacing=0 cellpadding=0>

<tr>
<td valign=top>
<?php print $rec->data['html_xml_description'];?>
</td>
</tr>
<tr>
<td>
<table border=1>
<tr>
<td width=200></td>
<td>
<?php print $rec->data['amount']." ".$config->currency;?>
<?php
print "<pre>";
print_r($xml2html->order_tab);
print "<HR>";
print_r($xml2html->user_tab);
print "</pre>";
?>

</td>
</tr>
</table>
