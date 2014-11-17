<?php
/**
* Menu g³ówne, które pokazuje siê po zalogowaniu sie klienta.
*
* @author rp@sote.pl m@sote.pl
* @version $Id: menu.inc.php,v 2.15 2006/01/23 09:06:28 lechu Exp $
* @package    users
*/

global $config;
global $global_basket_amount;
global $global_id_user;
global $_SESSION, $lang_id;

/* Obs³uga buttonów */
require_once("$DOCUMENT_ROOT/themes/include/buttons.inc.php");

$buttons =& new Buttons;

// jesli jest cos w koszyku, to wstaw button do realizacji zmaowienia
print "<div align=right>";
$tab=array();
if(empty($_SESSION['id_partner'])) {
    $tab[$lang->users_address_book]="/go/_users/address_book.php";
//    if($lang_id == 0) {
//        $tab[$lang->users_reminder]="/go/_users/reminder.php";
//    }
    $tab[$lang->users_change_data]="/go/_users/register1.php";

    //if ((@$_SESSION['form']['points']>0) || (! empty($_SESSION['__user_discount']))) {
      //  $tab[$lang->users_points]="/go/_users/account.php";
    //}
}
$tab[$lang->users_trans]="/go/_users/orders.php";

if(empty($_SESSION['id_partner'])) {
    if ($global_basket_amount>0) {
        $tab[$lang->take_order]="/go/_basket/index.php";
    }
    $tab[$lang->users_change_password]="/go/_users/password.php";
}
$tab[$lang->users_logout]="/go/_users/logout.php";


$buttons->menu_buttons($tab);
print "</div>";
?>
