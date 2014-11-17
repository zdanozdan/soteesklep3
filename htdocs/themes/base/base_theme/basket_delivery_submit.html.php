<?php
/**
* Wy¶wietl podsumowanie zawarto¶æi koszyka + przycisk potwierdzenia zamówienia.
*
* @author  m@sote.pl
* @version $Id: basket_delivery_submit.html.php,v 1.2 2006/11/23 17:57:58 tomasz Exp $
* @package htdocs_theme
* @subpackage basket
*
* @todo zmieniæ wywo³anie basket_amount.html.php
*/
?>

<?php 
/* Wy¶wietl informacje o wearto¶ci zamówienia itp. */
include_once("basket_amount.html.php");
?>
<br>
<table align="center" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td align="right" ></td>
    <td align="right" style="font: bold 13px Tahoma;color:#808080"><?php print $lang->second_step; ?></td>
  </tr>
  <tr>
  <td></td>
    <td align="right" >
      <button class="payment" type="submit" name="submit_proceed" value="<?php print $lang->basket_take_order ;?>">
       <?php
       print $lang->basket_take_order_payment;
       ?>
      </button>
      <input type="hidden" name=current_step value=2>
    <br><br>
    </td>
  </tr>
  <tr>
  <td align="left" >
      <?php $this->print_page("/go/_basket/print.php"); ?>
    </td>
  </tr>
</table>


<br />
