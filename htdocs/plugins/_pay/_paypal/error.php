<?php
/**
 * Powrot po platnosci karta
 *
 * @author r@sote.pl
 * @version $Id: error.php,v 1.2 2005/10/12 09:12:18 scalak Exp $
 * @package soteesklep
 */

$__no_session=true;
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("$DOCUMENT_ROOT/../include/head.inc");

//print "<pre>";
//print_r($_REQUEST);
//print "</pre>";

if (! empty($_REQUEST['sess_id'])) {
    $order_id=$_REQUEST['sess_id'];
    if (! ereg("^[0-9a-f]+$",$order_id)) {
	$theme->go2main();
	exit;
    }
} else {
    $theme->go2main();
    exit;
}

$query="SELECT order_id, session_id FROM order_register WHERE session_id=? LIMIT 1";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$order_id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
	if ($num_rows>0) {
            $session_id=$db->FetchResult($result,0,"session_id");
            $order_id=$db->FetchResult($result,0,"order_id");
    	    $str="/plugins/_pay/_paypal/sess_back_error.php?".$sess->param."=".$session_id."&ID=".$order_id;
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
