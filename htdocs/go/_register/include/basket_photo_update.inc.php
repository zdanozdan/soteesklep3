<?php
/**
* Aktualizuj numer order_id w zlaczonych zdjeciach do produktow
* katalog modulu: go/_basket/_photo/
*
* @author  m@sote.pl
* @version $Id: basket_photo_update.inc.php,v 2.3 2004/12/20 18:01:44 maroslaw Exp $
* @package    register
*/

if (@$global_secure_test!=true) {
    die ("Forbidden");
}

if (@$config->basket_photo!=true) {
    /**
    * Dodaj klasê obs³ugi transakcji.
    */
    require_once ("include/order/order.inc");
    if (empty($ord_reg)) {
        $ord_reg =& new OrderRegister;
    }
    $order_id=$ord_reg->getOrderID();
    $query="UPDATE basket_photo SET order_id=? WHERE session_id=? AND order_id=0";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$order_id);
        $db->QuerySetText($prepared_query,2,$sess->id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            // dane poprawnie zaktualizowane
        } else die ($db->Error());
    } else die ($db->Error());
} // end if
?>
