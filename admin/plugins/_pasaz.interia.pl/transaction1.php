<?php
/**
 * Transakcje do interia pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: transaction1.php,v 1.4 2005/12/23 14:37:21 scalak Exp $
* @package    pasaz.interia.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

// naglowek
$theme->head_window();
$theme->bar($lang->interia_bar['trans']);

print "<br><center>".$lang->interia_trans['timeout']."<br></center>";
flush();

require_once("include/interia/interia_transaction.inc.php");
$interia_trans=new interiaTransaction;

$order_id=$mdbd->select("order_id","order_register","partner_name=? AND confirm=1 AND (confirm_partner=1 OR confirm_partner=2)",array("interia"=>"string"),"ORDER BY order_id DESC");
foreach($order_id as $key=>$value) {
    $interia_trans->SendTrans($value['order_id'],2);
}

include_once ("./html/interia_close.html.php"); 

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
