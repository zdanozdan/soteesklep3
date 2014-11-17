<!-- basket_points_amount.html.php ->

<?php
/**
* Wy¶wietl podsumowanie zamówienia w koszyku. Warto¶c do zap³aty, koszty dostawy, informacje o promocji.
* 
* @author  m@sote.pl p@sote.pl
* @version $Id: basket_points_amount.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
global $shop;
?>

<?php
// start dodaj tlumaczenie:
if ($config->base_lang!=$config->lang) {
    $delivery_name=LangFunctions::f_translate($delivery_name);
}
// end dodaj tlumaczenie:
// start waluty:
// end waluty:
?>
<br />

<table border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td align="left"><?php print $lang->basket_amount_name; ?></td>
    <td>&nbsp;&nbsp;</td>
    <td align="left">
    </td>
  </tr>
  <tr>
    <td align="left"><?php print $lang->basket_points_cost; ?></td>
    <td>&nbsp;&nbsp;</td>
    <td align="left">
    <?php print $_SESSION['form']['points_reserved'];?>
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
    <td align="left"><b><?php print $lang->basket_points_left; ?></b></td>
    <td>&nbsp;&nbsp;</td>
    <td align="left">
      <B>
          <?php print $_SESSION['form']['points'];?>
      </B>
    </td>
  </tr>
  

</table>

<br />
