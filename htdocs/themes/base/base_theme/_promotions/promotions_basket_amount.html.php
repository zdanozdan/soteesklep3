PROMOTIONS3<?php
/**
* Wyswietl informacja o promocji
*
* @author  m@sote.pl
* @version $Id: promotions_basket_amount.html.php,v 1.6 2004/12/20 18:02:29 maroslaw Exp $
* @package    promotions
*/

print "<div align=\"left\">\n";
print $lang->promotions_basket_name.": <b>".@$_SESSION['__promotions']['name']."</b><br />";
print $lang->promotions_basket_amount.": ";
print $this->amount;
print " ".$shop->currency->currency."\n";
print " (".$lang->promotions_basket_discount.":".@$_SESSION['__promotions']['discount']."%)<br />\n";
print $lang->promotions_order_amount.": <b>";
print $this->curr_total_amount." ".$shop->currency->currency."</b>";
if ($shop->currency->changed()) {
     print "($this->total_amount $config->currency)";
}
print "<p />\n";
print "</div>\n";
?>
