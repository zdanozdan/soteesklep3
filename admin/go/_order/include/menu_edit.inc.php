<?php
/**
* Menu nad edycja transakcji
*
* @author  m@sote.pl
* @version $Id: menu_edit.inc.php,v 2.6 2004/12/20 17:58:55 maroslaw Exp $
* @package    order
*/

/**
* \@global int $__user_exists 1 - user zarejestrowany, 0 - w p.w.
*/

// wstaw link do edycji danych uzytkwonika
global $__user_exists;
$__user_exists=0;
$data=array();

if (! empty($_REQUEST['order_id'])) {
    $order_id=$_REQUEST['order_id'];   
    
} else $order_id='';


print "<div align=right>";

$data[$lang->order_menu['edit']]="/go/_order/edit.php?order_id=$order_id";

if (! empty($rec->data['id_user'])) {
    $id_user=$rec->data['id_user'];
    
    // sprawdz, czy dany user istnieje w bazie uzytkownikow (tabela users)
    $id_user=$mdbd->select("id","users","id=?",array(@$rec->data['id_user']=>"int"));
    if ($id_user>0) {
        $__user_exists=1;
        $data[$lang->order_menu['users']]="/go/_users/edit.php?id=$id_user";
    }    
}

if (! empty($rec->data['id_users_data'])) {
    $data[$lang->order_menu['users_data']]="/go/_users/edit.php?id=".$rec->data['id_users']."&order_id=$order_id";
}

$data[$lang->order_menu['info']]="/go/_order/info.php?id=$id&order_id=$order_id";



$buttons->menu_buttons($data);
print "</div>";
?>
