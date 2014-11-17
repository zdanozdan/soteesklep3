<?php
/**
 * Lista transakcji wp.
 * 
 * @author  rdiak@sote.pl
 * @version $Id: interia_trans.php,v 2.1 2005/04/04 10:06:58 scalak Exp $
* @package    order
 */

// lista transakcji
$sql="SELECT * FROM order_register WHERE partner_name='interia' AND confirm=1 AND (confirm_partner=1 OR confirm_partner=2) AND record_version='30' ORDER BY order_id DESC";
/**
 * Wy¶wietl listê transakcji
 */
require_once ("./include/order_list.inc.php");
?>
