<?php
/**
* Wyswlij maila z zamowieniem do sprzedawcy oraz wyslij potwierdzenie zamowienia do klienta
*
* @author  m@sote.pl
* @version $Id: send_order.inc.php,v 2.15 2004/12/20 18:01:46 maroslaw Exp $
* @package    register
*/

if (! @$__secure_test==true) die ("Forbidden");

require_once ("include/order/send.inc");
$order_send =& new OrderSend;
$confirm=$order_send->send();
?>
