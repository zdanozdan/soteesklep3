<?php
/**
* Odczytaj paratery id i order_id dla transakcji.
*
* @author  m@sote.pl
* @version $Id: get_order_id.inc.php,v 2.3 2004/12/20 17:58:55 maroslaw Exp $
* @package    order
*/

/**
* \@global int $id
* \@global int $order_id
*/

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    if (! ereg("^[0-9]+$",$id)) die ("Forbidden: ID");
    $order_id=$mdbd->select("order_id","order_register","id=?",array($id=>"int"),"LIMIT 1");
} elseif (! empty($_REQUEST['order_id'])) {
    $order_id=$_REQUEST['order_id'];
    if (! ereg("^[0-9]+$",$order_id)) die ("Forbidden order_id");
    $id=$mdbd->select("id","order_register","order_id=?",array($order_id=>"int"),"LIMIT 1");
} else {
    die ("Forbidden: ID");
}
?>
