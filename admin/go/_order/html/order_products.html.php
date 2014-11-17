<?php
/**
* Szablon prezentacji zamówienia (produkty).
*
* @author  m@sote.pl
* @version $Id: order_products.html.php,v 2.3 2004/12/20 17:58:53 maroslaw Exp $
* @package    order
*/

/**
* \@global int    $order_id order_id zamówienia
* \@global object $order_products 
*/

$order_products->addForm();
print $order_products->getProductsInfo($order_id);
?>
