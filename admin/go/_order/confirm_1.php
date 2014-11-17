<?php
/**
* Lista transkacji zap³aconych
*
* @author  m@sote.pl
* @version $Id: confirm_1.php,v 2.3 2004/12/20 17:58:46 maroslaw Exp $
* @package    order
*/

$sql="SELECT * FROM order_register WHERE (confirm=1 OR confirm_online=1) AND record_version='30' ORDER BY order_id DESC";
/**
* Wy¶wietl listê transakcji
*/
require_once ("./include/order_list.inc.php");
?>
