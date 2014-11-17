<?php
/**
* Powrot po poprawnej autoryzacji PolCard.
* Przekierowanie na confirm_sess.php z przekazaniem parametru sesji $session_id
* @param int $order_id (POST)
*
* @author  m@sote.pl
* @version $Id: confirm.php,v 1.7 2006/02/15 09:49:01 lukasz Exp $
* @package    pay
* @subpackage polcard
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
include_once ("../../../../include/head.inc");
if (! empty($_REQUEST['order_id'])) {
    $order_id=$_REQUEST['order_id'];
} else die ("Bledne wywolanie");

$query="SELECT session_id FROM order_register WHERE order_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$order_id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $session_id=$db->FetchResult($result,0,"session_id");
            //print "session_id=$session_id <BR>";
            global $mdbd;
    		$p24_session=$_REQUEST['sess_id'];
    		$order_id=$mdbd->select('order_id','order_register',"session_id='$p24_session'",'','LIMIT 1');
    		if (!empty($order_id)) {
    			$session=$mdbd->select('data','order_session',"order_id='$order_id'");
    			if (!empty($session)) {
    				$_SESSION=unserialize($session);
    				// zapalamy flage
    				$session_restored=true;
    			}
    		}
            include ("./sess_confirm.php");
            
        } else {
            die ("Forbidden");
        }
    } else die ($db->Error());
} else die ($db->Error());


include_once ("include/foot.inc");

?>
