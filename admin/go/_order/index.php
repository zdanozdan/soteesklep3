<?php
/**
 * Lista wszystkich transakcji.
 * 
 * @author  m@sote.pl
 * @version $Id: index.php,v 2.11 2004/12/20 17:58:47 maroslaw Exp $
* @package    order
 */

// lista transakcji
$sql="SELECT * FROM order_register WHERE record_version='30' ORDER BY order_id DESC";
/**
* Wy¶wietl listê transakcji
*/
require_once ("./include/order_list.inc.php");
?>
