<?php
/**
 * Strona pobierania kategorii allegro.
 *
 * @author  rdiak@sote.pl
 * @version $Id: allegro_category.html.php,v 1.1 2006/03/29 07:00:25 scalak Exp $
 * @package allegro.pl
 */
$onclick="onclick=\"window.open('','allegro_category','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>
<?php print $lang->allegro_category['info']; ?>
<form action=category1.php name="allegro_category" method=POST target=allegro_category>
<p>
<table align=center width=95%><tr><td>
<center><?php //print $lang->allegro_category['category']; ?></center>
<p>
</td></tr>

<tr>
<td align=center>
<table>
<tr>
<td align=left width=300>

<fieldset>
<legend><?php print $lang->allegro_options['data'] ?> </legend>
<INPUT type=radio name=get_param value="GetTree"><?php print $lang->allegro_options['cat'] ?><br> 
<INPUT type=radio name=get_param value="GetOther"><?php print $lang->allegro_options['other'] ?><br> 

<!--<INPUT type=radio name=get_param value="GetAllProducts" disabled><?php //print $lang->allegro_options['all_prod'] ?><br>
<INPUT type=radio name=get_param value="GetOneProduct" disabled><?php //print $lang->allegro_options['one_prod'] ?>&nbsp;&nbsp;
<INPUT type=text name=id_get_param size=5 disabled>&nbsp;&nbsp; <?php //print $lang->allegro_options['id_one_prod'] ?>
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
      $buttons->button($lang->allegro_category['submit'],"javascript:document.allegro_category.submit(); $onclick");
   ?>
</center>
</td></tr>
</table>
</from>
