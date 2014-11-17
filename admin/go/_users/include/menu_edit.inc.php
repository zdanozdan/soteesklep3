<?php
/**
 * \@global integer $global_id_user id uzytkownika (klucz glowny tabeli users)
* @version    $Id: menu_edit.inc.php,v 2.9 2005/12/27 11:59:30 lukasz Exp $
* @package    users
* \@ask4price
 */

// odczytaj id klienta
if (! empty($_REQUEST['id'])) {
    $rec->data['id']=$_REQUEST['id'];
}

if (! empty($_REQUEST['order_id'])) {    
    $rec->data['order_id']=$_REQUEST['order_id'];
}

global $mdbd; 

$data=array();


if (! empty($rec->data['order_id'])) {
    $data[$lang->users_menu['edit_order']]="/go/_order/edit.php?order_id=".$rec->data['order_id'];
}
$data[$lang->users['points']]="/go/_users/points.php?id=".@$rec->data['id']."&order_id=".@$rec->data['order_id'];
$data[$lang->users_menu['order']]="/go/_order/users.php?id=".@$rec->data['id']."&order_id=".@$rec->data['order_id'];
$data[$lang->users_menu['users']]="edit.php?id=$id&order_id=".@$rec->data['order_id'];

$mdbd->select("id", "ask4price", "id_users=?", array($_REQUEST['id'] => "int"));
if($mdbd->num_rows > 0) {
    $data[$lang->users_menu['requests']]="ask4price.php?id=$id";
}

print "<div align=right>";
$buttons->menu_buttons($data);
print "</div>";

?>
