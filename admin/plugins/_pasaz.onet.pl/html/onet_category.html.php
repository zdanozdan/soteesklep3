<?php
/**
 * Strona pobierania kategorii onetowych.
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_category.html.php,v 1.5 2004/12/20 18:00:30 maroslaw Exp $
 *
* @package    pasaz.onet.pl
 */
$onclick="onclick=\"window.open('','onet_category','width=515,height=350,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>
<br>
<?php print $lang->onet_category['info']; ?>
<form action=category1.php name="onet_category" method=POST target=onet_category>
<p>
<table align=center width=95%><tr><td>
<center><?php print $lang->onet_category['category']; ?></center>
<p>
</td></tr>
<tr><td>
<center>
   <?php
      $buttons->button($lang->onet_category['submit'],"javascript:document.onet_category.submit(); $onclick");
   ?>
</center>
</td></tr>
</table>
</from>
