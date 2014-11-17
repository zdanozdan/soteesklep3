<?php
/**
 * Lista transakcji onetowych.
 * 
 * @author  rdiak@sote.pl
 * @version $Id: onet_trans.php,v 2.3 2004/12/20 17:58:47 maroslaw Exp $
* @package    order
 */

// lista transakcji
$sql="SELECT * FROM order_register WHERE partner_name='onet' AND confirm=1 AND confirm_partner=1 AND record_version='30' ORDER BY order_id DESC";
/**
 * Wy¶wietl listê transakcji
 */
require_once ("./include/order_list.inc.php");
?>
