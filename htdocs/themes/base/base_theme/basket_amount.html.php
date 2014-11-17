<br>
<div style="text-align:left;">
<table>
<tr><td style="text-align:left;">
<b>
<?php
   global $lang;
   print $lang->basket_order_summary;
?>:</b>
</td></tr>
</table>
</div>
<div class="block_1"><?php
/**
* Wy¶wietl podsumowanie zamówienia w koszyku. Warto¶c do zap³aty, koszty dostawy, informacje o promocji.
* 
* @author  m@sote.pl p@sote.pl
* @version $Id: basket_amount.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
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
  <tr>
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
      print "<span style=font-size:larger>".$shop->currency->price($order_amount);
      print " ".$shop->currency->currency."</span>";    
      ?>
      </B>
    </td>
  </tr>
</table>

<br />
</div>
<?php
/* Wy¶wietl informacje o promocji */
global $shop;
$shop->promotions();
$shop->promotions->basketInfo();
?>
