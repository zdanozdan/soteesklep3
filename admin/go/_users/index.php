<?php
/**
* Lista wszystkich klientów w sklepie. Dane klientów zarejestrowanych.
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.6 2004/12/20 17:59:14 maroslaw Exp $
* @package    users
*/

$sql="SELECT * FROM users WHERE order_data!=1 AND record_version='30' ORDER BY id DESC";
/**
* Lista klientów zarejestrowanych.
*/
require_once ("./include/users_list.inc.php");
?>
