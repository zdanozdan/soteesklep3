<?php
/**
* Formularz dodania produktu do zamówienia.
*
* @author  m@sote.pl
* @version $Id: product_add_form.html.php,v 2.7 2005/08/11 10:53:35 lechu Exp $
* @package    order
*/

global $order_print;
if($order_print == true) {
	echo '';
}
else {
?>

<table width="100%">
<tr>
  <td>
    <table cellspacing="1" cellpadding="2" border="0">
    <tr>
      <td><nobr><?php print $lang->order_products['user_id'];?></nobr><input type=text name=products_add[user_id] size=8></td>
      <td><nobr></b><?php print $lang->order_products['name'];?></nobr><input type=text name=products_add[name] size=20></td>
      <td><nobr><?php print $lang->order_products['options'];?></nobr><input type=text name=products_add[options] size=10></td>
      <td><nobr><?php print $lang->order_products['price_brutto'];?></nobr><input type=text name=products_add[price_brutto] size=8></td>
      <td><nobr><?php print $lang->order_products['vat']."%";?></nobr><input type=text name=products_add[vat] size=2></td>
      <td><nobr><?php print $lang->order_products['num'];?></nobr><input type=text name=products_add[num] size=4></td>
      <td><input type=submit value="Dodaj"></td>
    </tr>
    </table>
  </td>
  <td align=right>  
    <input type=submit value='<?php print $lang->edit_submit;?>'>
  </td>
</tr>
</table>
<?php
}
?>