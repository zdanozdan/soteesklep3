<?php
/**
 * Potwierdzenie transakcji, skrypt wywolywany prez Onet
 * 
 * @author m@sote.pl
 * @param int $transactionId numer potwierdzanej transakcji (GET)
 * @return STDOUT "OK" jesli tarkacja jest OK, "" w przeciwnym wypadku
 * @version $Id: check.php,v 1.3 2005/01/20 15:00:28 maroslaw Exp $
* @package    pasaz.onet.pl
 */
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

if (! empty($_REQUEST['transactionId'])) {
    $transactionId=$_REQUEST['transactionId'];
} else exit;


$query="SELECT order_id FROM order_register WHERE order_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$transactionId);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // jest taka transakcja
            print "OK";
            exit;
        } else {
            // nie ma tranakcji
            print "Error";
            exit; 
        }
    } else die ($db->Error());
} else die ($db->Error());


include_once ("include/foot.inc");
?>
