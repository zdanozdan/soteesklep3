<?php
/**
* @version    $Id: menu.inc.php,v 1.2 2004/12/20 18:01:57 maroslaw Exp $
* @package    users
*/
global $config;
global $global_basket_amount;
global $global_id_user;
global $_SESSION;

require_once("$DOCUMENT_ROOT/themes/include/buttons.inc.php");

$buttons = new Buttons;

    // jesli jest cos w koszyku, to wstaw button do realizacji zmaowienia
print "<div align=right>";
if ($global_basket_amount>0) {
    $tab=array(
               "$lang->users_address_book"=>"/go/_users/address_book.php",
               "$lang->users_reminder"=>"/go/_users/reminder.php",
               "$lang->users_change_data"=>"/go/_users/register1.php",
               "$lang->users_points"=>"/go/_users/account.php",
               "$lang->users_trans"=>"/plugins/_transuser/index.php",
               "$lang->take_order"=>"/go/_register/index.php",
               "$lang->users_change_password"=>"/go/_users/password.php",
               "$lang->users_logout"=>"/go/_users/logout.php"                              
               );
} else {
    $tab=array(
               "$lang->users_address_book"=>"/go/_users/address_book.php",
               "$lang->users_reminder"=>"/go/_users/reminder.php",
               "$lang->users_change_data"=>"/go/_users/register1.php",
               "$lang->users_points"=>"/go/_users/account.php",
               "$lang->users_trans"=>"/plugins/_transuser/index.php",
               "$lang->users_change_password"=>"/go/_users/password.php",
               "$lang->users_logout"=>"/go/_users/logout.php"                              
               );
}

if (in_array("sales",$config->plugins)) {
    if (@$_SESSION['__id_sales']>0) {
        $tab=array_reverse($tab,true);
        $tab[$lang->users_sales]="/go/_users/sales.php";
        $tab=array_reverse($tab,true);
    }
}

$buttons->menu_buttons($tab);
print "</div>";  			     
?>
