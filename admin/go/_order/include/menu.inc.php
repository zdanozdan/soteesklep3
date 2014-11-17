<?php
/**
* Menu edycji transkacji.
*
* @author  m@sote.pl
* @version $Id: menu.inc.php,v 2.18 2005/12/12 08:08:17 lechu Exp $
* @package    order
*/

/**
* Za³±cz g³ówne menu transakcji.
*/
if (@$__no_head!=1) {
    include_once ("include/menu_top.inc.php");
    
    print "<div align=right>";
    
    
    $buttons->menu_buttons(array(// $lang->order_buttons['add']=>"add.php",
    $lang->order_buttons['list']=>"index.php",
    $lang->order_buttons['not_paid']=>"no_confirm.php",
    $lang->order_buttons['paid']=>"confirm_1.php",
    $lang->search=>"search.php",
    $lang->order_buttons['points']=>"/go/_points/configure.php",
    $lang->help=>"/plugins/_help_content/help_show.php?id=3 onClick=\"open_window(300,500);\" target=window",
    )
    );
    
    print "</div>";
} else {
    if (! empty($_REQUEST['order_id'])) {
        $order_id=$_REQUEST['order_id'];
    } else $order_id='';
    
    $data=array();
    if (! empty($order_id)) {
        $data[$lang->order_menu['edit']]="/go/_order/edit.php?order_id=".$order_id;
    }
        
    $data[$lang->order_menu['users_points']]="/go/_users/points.php?id=$id&order_id=$order_id";
    $data[$lang->order_menu['users_order']]="/go/_order/users.php?id=$id&order_id=$order_id";
    $data[$lang->order_menu['users']]="/go/_users/edit.php?id=$id&order_id=$order_id";

    print "<div align=right>";    
    $buttons->menu_buttons($data);
    print "</div>";
}
?>
