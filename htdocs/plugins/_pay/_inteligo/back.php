<?php
/**
 * Powrot po autoryzacji Inteligo, przekeirowanie na sess_back.php z dodaniem sesji
 *
 * @author  rdiak@sote.pl
 * \@modified_by m@sote.pl 2003/10/26 drobne poprawki dot. zgodnosci ze standardami SOTE
 * @version $Id: back.php,v 1.6 2005/01/20 15:00:29 maroslaw Exp $
* @package    pay
* @subpackage inteligo
 */

$__no_session=true;
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../../include/head.inc");


if (! empty($_REQUEST['CustomParam'])) {
    $order_id=$_REQUEST['CustomParam'];
    if (! ereg("^[0-9]+$",$order_id)) {
        $theme->go2main();
	exit;
    }
} else {
    $theme->go2main();
    exit;
}


$_REQUEST['Description']=urlencode(@$_REQUEST['Description']);
$_REQUEST['TxID']=urlencode(@$_REQUEST['TxID']);
$_REQUEST['MerchantID']=urlencode(@$_REQUEST['MerchantID']);
$_REQUEST['Amount']=urlencode(@$_REQUEST['Amount']);
$_REQUEST['ControlData']=urlencode(@$_REQUEST['ControlData']);
$_REQUEST['CustomParam']=urlencode(@$_REQUEST['CustomParam']);
$_REQUEST['Currency']=urlencode(@$_REQUEST['Currency']);

$query="SELECT session_id FROM order_register WHERE order_id=? LIMIT 1";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$order_id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $session_id=$db->FetchResult($result,0,"session_id");
	    $str="/plugins/_pay/_inteligo/sess_back.php?TxID=".$_REQUEST['TxID']."&MerchantID=".$_REQUEST['MerchantID']."&Amount=".$_REQUEST['Amount']."&Currency=".$_REQUEST['Currency']."&CustomParam=".$_REQUEST['CustomParam']."&ControlData=".$_REQUEST['ControlData']."&Description=".$_REQUEST['Description']."&".$sess->param."=".$session_id;
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
