<?php
/**
 * Lista transakcji wszystkich partnerów.
 * 
 * @author  rdiak@sote.pl
 * @version $Id: partner_trans.php,v 2.3 2004/12/20 17:58:48 maroslaw Exp $
* @package    order
 */

// lista transakcji
$sql="SELECT * FROM order_register WHERE partner_id!=0 AND record_version='30'";
/**
 * Wy¶wietl listê transakcji
 */
require_once ("./include/order_list.inc.php");
?>
