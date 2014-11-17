<?php
/**
* Formularz wyszukiwania transakcji.
*
* @author  m@sote.pl
* @version $Id: search.html.php,v 2.4 2004/12/20 17:58:54 maroslaw Exp $
* @package    order
*/

global $my_date;
?>

<p>
<center>
<?php print $lang->search_date;?><input type=checkbox name=form[search_date] value=1>
</center>
<table align=center border=0 cellspacing=3>
<tr>
  <td><?php print $lang->search_from;?></td>
  <td><?php print $my_date->days("from");?></td>
  <td><?php print $my_date->months("from");?></td>
  <td><?php print $my_date->years("from");?></td>
  <td><?php print $lang->search_to;?></td>
  <td><?php print $my_date->days("to");?></td>
  <td><?php print $my_date->months("to");?></td>
  <td><?php print $my_date->years("to");?></td>
</tr>
</table>

<table align=center border=0 cellspacing=3>
<tr>
  <td><?php print $lang->order_search['order_id'];?></td><td><input type=text size=6 name=form[order_id]></td>
</tr>
<tr>
  <td valign=bottom><?php print $lang->order_search['amount']."&nbsp;";?></td>
  <td valign=bottom><?php print $lang->search_from." ";?><input type=text size=6 name=form[amount_from]></td>
  <td valign=bottom><?php print $lang->search_to." ";?><input type=text size=6 name=form[amount_to]><?php print $config->currency;?></td>
</tr>
</table>

<table border=0 align=center cellspacing=3>
<tr>
  <td><?php print $lang->order_search['pay_method'];?></td><td><?php show_pay_methods("form[pay_method]");?></td>
</tr>
<tr>
  <td><?php print $lang->order_search['status'];?></td><td><?php print show_select_order("form[status]");?></td>
</tr>
<tr>
  <td><?php print $lang->order_search['confirm'];?></td><td><?php show_confirm("form[confirm]");?></td>
</tr>
<tr>
  <td><?php print $lang->order_search['partner'];?></td><td><?php show_partner("form[partner]");?></td>
</tr>

<!-- ocena ryzyka -->
<?php
if (in_array("confirm_online",$config->plugins)) {
?>
<tr>
  <td>
  <?php  
       print $lang->order_fraud_attention." <img src=";$theme->img("_img/attention.png"); print " width=15 height=14>";  
  ?>
 </td>
 <td align=left>
    <input type=checkbox name=form[fraud_attention] value=1>
 </td>
</tr>
<?php
}
?>
<!-- end -->
<tr>
   <td colspan=2 align=center>
    <?php print $lang->and;?><input type=radio name=form[and] value=1 checked>
    <?php print $lang->or;?><input type=radio name=form[and] value=0>
  </td>
</tr>
<tr>
 <td colspan=2 align=right><input type=submit value='<?php print $lang->search_submit;?>'></td>
</tr>
</table>

<p><br>
