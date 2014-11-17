<?php
/**
* Wy¶wietl podsumowanie zawarto¶æi koszyka + przycisk potwierdzenia zamówienia w przypadku produktów kupowanych za punkty.
*
* @author  lukasz@sote.pl
* @version $Id: basket_delivery_points_submit.html.php,v 1.1 2006/09/27 21:53:21 tomasz Exp $
* @package htdocs_theme
* @subpackage basket
*
*/
?>

<?php 
/* Wy¶wietl informacje o wearto¶ci zamówienia itp. */
include_once("basket_points_amount.html.php");
?>
<div align="left">
<table align="center" cellpadding="0" cellspacing="0" border="0">
  <tr>
  <td align="leftr" valign="top">
      <?php $this->print_page("/go/_basket/print.php"); ?>
    </td>
    <td align="center" style="padding: 7px;" valign="top">
      <input type="submit" name="submit_proceed" value="<?php print $lang->basket_take_order ;?>">
    </td>
  </tr>
</table>
</div>
<br />
