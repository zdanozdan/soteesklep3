<?php
/**
 * Strona pobierania kategorii wp.
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_category.html.php,v 1.7 2004/12/20 18:00:34 maroslaw Exp $
 *
* @package    pasaz.wp.pl
 */
$onclick="onclick=\"window.open('','wp_category','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>
<?php print $lang->wp_category['info']; ?>
<form action=category1.php name="wp_category" method=POST target=wp_category>
<p>
<table align=center width=95%><tr><td>
<center><?php //print $lang->wp_category['category']; ?></center>
<p>
</td></tr>

<tr>
<td align=center>
<table>
<tr>
<td align=left width=300>

<fieldset>
<legend><?php print $lang->wp_options['data'] ?> </legend>
<INPUT type=radio name=get_param value="IsValidTree" checked><?php print $lang->wp_options['vtree'] ?><br>
<INPUT type=radio name=get_param value="GetTree"><?php print $lang->wp_options['cat'] ?><br> 
<INPUT type=radio name=get_param value="GetAdvantages" ><?php print $lang->wp_options['adv'] ?><br>
<INPUT type=radio name=get_param value="GetProducers" ><?php print $lang->wp_options['prod'] ?><br>
<INPUT type=radio name=get_param value="GetFieldsMeaning" ><?php print $lang->wp_options['field'] ?><br>
<INPUT type=radio name=get_param value="GetLocalFilters" ><?php print $lang->wp_options['filter'] ?><br>

<!--<INPUT type=radio name=get_param value="GetAllProducts" disabled><?php //print $lang->wp_options['all_prod'] ?><br>
<INPUT type=radio name=get_param value="GetOneProduct" disabled><?php //print $lang->wp_options['one_prod'] ?>&nbsp;&nbsp;
<INPUT type=text name=id_get_param size=5 disabled>&nbsp;&nbsp; <?php //print $lang->wp_options['id_one_prod'] ?>
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
      $buttons->button($lang->wp_category['submit'],"javascript:document.wp_category.submit(); $onclick");
   ?>
</center>
</td></tr>
</table>
</from>
