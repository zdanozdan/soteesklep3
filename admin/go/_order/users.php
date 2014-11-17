<?php
/** 
* Lista transakcji dla danego klienta.
*
* @author  m@sote.pl
* @version $Id: users.php,v 2.3 2005/10/13 11:36:08 lukasz Exp $
* @package    order
*/

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];   
    if (! ereg("^[0-9]+$",$id)) die ("Forbidden ID");
} else die ("Forbidden");

$id=addslashes($id);
//$id_users=addslashes($id_users);
$sql="SELECT * FROM order_register WHERE id_users=$id OR id_users_data=$id ORDER BY id DESC";

/**
* Wy¶wietl listê transakcji
*/
$__no_head=1;
require_once ("./include/order_list.inc.php");
?>
