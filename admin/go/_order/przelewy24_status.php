<?php
/**
* Sprawdzenie statusu transakcji w przelewy24.pl
*
* @author  m@sote.pl
* @version $Id: przelewy24_status.php,v 2.4 2005/01/20 14:59:35 maroslaw Exp $
* @package    order
*/

/**
* \@global $order_id GET
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

$sess_id="1234";
$order_id="1234";
$pos_id=1053;

/**
* Obs³uga klienta HTTP
*/
require_once ("HTTP/Client.php");
$http =& new HTTP_Client();
$http->get("https://secure.przelewy24.pl/transakcja.php");
/*array
(
"p24_session_id"=>$sess_id,
"p24_order_id"=>$order_id,
"p24_id_sprzedawcy"=>$pos_id,
));
*/
$data=$http->_responses[0]['body'];

print "<pre>";print_r($data);print "</pre>";

$theme->head_window();

$theme->bar($lang->order_przelewy24_cstatus_check_title);

$theme->foot_window();
include_once ("include/foot.inc");
?>
