<?php
/**
 * Strona pobierania kategorii interia.
 *
 * @author  rdiak@sote.pl
 * @version $Id: interia_category.html.php,v 1.1 2005/03/29 15:13:59 scalak Exp $
 *
* @package    pasaz.interia.pl
 */
$onclick="onclick=\"window.open('','interia_category','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>
<?php print $lang->interia_category['info']; ?>
<form action=category1.php name="interia_category" method=POST target=interia_category>
<p>
<table align=center width=95%><tr><td>
<center><?php //print $lang->interia_category['category']; ?></center>
<p>
</td></tr>

<tr>
<td align=center>
<table>
<tr>
<td align=left width=300>

<fieldset>
<legend><?php print $lang->interia_options['data'] ?> </legend>
<INPUT type=radio name=get_param value="GetTree" checked><?php print $lang->interia_options['cat'] ?><br> 

<!--<INPUT type=radio name=get_param value="GetAllProducts" disabled><?php //print $lang->interia_options['all_prod'] ?><br>
<INPUT type=radio name=get_param value="GetOneProduct" disabled><?php //print $lang->interia_options['one_prod'] ?>&nbsp;&nbsp;
<INPUT type=text name=id_get_param size=5 disabled>&nbsp;&nbsp; <?php //print $lang->interia_options['id_one_prod'] ?>
-->
<br>
</fieldset>
</td>
</tr>

</table>
</td>
</tr>
<tr><td>
<center>
   <?php
      $buttons->button($lang->interia_category['submit'],"javascript:document.interia_category.submit(); $onclick");
   ?>
</center>
</td></tr>
</table>
</from>
