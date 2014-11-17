<?php
/**
* Za³±cz klasê OrderChecksum z nowej lokalizacji.
*
* @deprecated ver. 3.0
* @ignore
* @version    $Id: order_register.inc,v 2.7 2004/12/20 18:02:55 maroslaw Exp $
* @package    include
*/

/**
* Plik z klas± OrderChecksum.
*/
require_once ("include/order/checksum.inc");
/**
* Klasa pomocnicza (zmiana nazwy klasy, wymagana dla starszych modu³ów)
* @package order
* @subpackage htdocs
* @ignore
*/
class OrderRegisterChecksum extends OrderChecksum {}
?>
