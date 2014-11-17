<?php
/**
 *  Uzytkwonik zostal dodany (zaktulizowany)
 *
 * @author m@sote.pl
 * @version $Id: update_ok.inc.php,v 2.2 2004/12/20 18:01:56 maroslaw Exp $
* @package    users
 */

if ($global_secure_test!=true) {
    die ("Bledne wywolanie");
}

$theme->bar($lang->bar_title['users']);
if ($global_basket_amount>0) {
    // informacja o zarejestrowaniu uzytkownika
    $theme->users_registered();
    // koszyk nie jest pusty, realizuj zamowienie
    $theme->users_go2register();
} else {
    $theme->users_registered();
}


?>
