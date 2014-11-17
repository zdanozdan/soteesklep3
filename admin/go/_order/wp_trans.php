<?php
/**
 * Lista transakcji wp.
 * 
 * @author  rdiak@sote.pl
 * @version $Id: wp_trans.php,v 2.3 2004/12/20 17:58:49 maroslaw Exp $
* @package    order
 */

// lista transakcji
$sql="SELECT * FROM order_register WHERE partner_name='wp' AND confirm=1 AND (confirm_partner=1 OR confirm_partner=2) AND record_version='30' ORDER BY order_id DESC";
/**
 * Wy¶wietl listê transakcji
 */
require_once ("./include/order_list.inc.php");
?>
