<?php
/**
* Wy¶wietl podsumowanie zamówienia w koszyku. Warto¶c do zap³aty, koszty dostawy, informacje o promocji.
* 
* @author  m@sote.pl p@sote.pl
* @version $Id: basket_amount.html.php,v 1.1 2005/08/10 09:52:36 krzys Exp $
* @package    themes
* @subpackage base_theme
*/
?>

<?php
// start dodaj tlumaczenie:
if ($config->base_lang!=$config->lang) {
    $delivery_name=LangFunctions::f_translate($delivery_name);
}
// end dodaj tlumaczenie:
// start waluty:
global $shop;
$shop->currency();
// end waluty:
?> 
<br />
<div align="left">
<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="left"><?php print $lang->basket_amount_name; ?></td>
    <td>&nbsp;&nbsp;</td>
    <td align="left">
    <?php 
    print $shop->currency->price($amount); 
    print " ".$shop->currency->currency;
    ?>
    </td>
  </tr>
  <tr> 
    <td align="left"><?php print $lang->basket_delivery_country; ?></td>
    <td>&nbsp;&nbsp;</td>
    <td align="left">
    <?php 
    print $lang->country[$_SESSION['global_country_delivery']]; 
    ?>
    </td>
  </tr>
    <td align="left"><?php print $lang->basket_delivery_cost; ?></td>
    <td>&nbsp;&nbsp;</td>
    <td align="left">
    <?php 
    print $shop->currency->price($delivery_cost);
    print " ".$shop->currency->currency." ($delivery_name)";
    ?>
    </td>
  </tr>
  <tr> 
    <td align="left"><b><?php print $lang->basket_total_order_amount; ?></b></td>
    <td>&nbsp;&nbsp;</td>
    <td align="left">
      <B>
      <?php 
      $default_order_amount=$order_amount;
      print $shop->currency->price($order_amount);
      print " ".$shop->currency->currency;    
      ?>
      </B>
    </td>
  </tr>
</table>
</div>
<br />

