<?php
/**
* Lista transkacji nie rozliczonych
*
* @author  m@sote.pl
* @version $Id: no_confirm.php,v 2.6 2004/12/20 17:58:47 maroslaw Exp $
* @package    order
*/

$sql="SELECT * FROM order_register WHERE confirm=0 AND record_version='30' ORDER BY order_id DESC";
/**
* Wy¶wietl listê transakcji
*/
require_once ("./include/order_list.inc.php");
?>
