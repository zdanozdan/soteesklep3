<?php
/**
 * Powrot po platnosci karta
 *
 * @author r@sote.pl
 * @version $Id: back.php,v 1.6 2006/02/15 09:48:57 lukasz Exp $
 * @package soteesklep
 */

$__no_session=true;
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("$DOCUMENT_ROOT/../include/head.inc");

if (! empty($_REQUEST['ID'])) {
    $order_id=$_REQUEST['ID'];
    if (! ereg("^[0-9a-f]+$",$order_id)) {
        $theme->go2main();
        exit;
    }
} else {
    $theme->go2main();
    exit;
}
$query="SELECT order_id, session_id FROM order_register WHERE order_id=? LIMIT 1";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$order_id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if($num_rows>0) {
            $session_id=$db->FetchResult($result,0,"session_id");
            $order_id=$db->FetchResult($result,0,"order_id");
            $str="/plugins/_pay/_paypal/sess_back.php?".$sess->param."=".$session_id."&ID=".$order_id."&payer_id=".$_REQUEST['payer_id']."&payer_email=".$_REQUEST['payer_email']."&txn_id=".$_REQUEST['txn_id']."&payment_type=".$_REQUEST['payment_type']."&receiver_email=".$_REQUEST['receiver_email']."&payment_gross=".$_REQUEST['payment_gross']."&receiver_id=".$_REQUEST['receiver_id'];
            header("Location: http://".$_SERVER['HTTP_HOST'].$str);
            exit;
        } else {
            $theme->go2main();
            exit;
        }
    } else die ($db->Error());
} else die ($db->Error());

include_once ("include/foot.inc");
?>
