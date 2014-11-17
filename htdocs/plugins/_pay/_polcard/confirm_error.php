<?php
/**
* Powrot po poprawnej autoryzacji PolCard.
* Przekierowanie na confirm_sess.php z przekazaniem parametru sesji $session_id
* @param int $order_id (POST)
*
* @author m@sote.pl
* @version $Id: confirm_error.php,v 1.6 2005/01/20 15:00:32 maroslaw Exp $
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
            print "
              <html>
                <head>
                  <META HTTP-EQUIV=\"refresh\" content=\"0; url=sess_confirm_false.php?$sess->param=$session_id\">
                </head>
              <html>
            ";
        } else {
            die ("Forbidden");
        }
    } else die ($db->Error());
} else die ($db->Error());


include_once ("include/foot.inc");

?>
