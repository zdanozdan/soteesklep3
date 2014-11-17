<?php
/**
 * Wyloguj uzytkwonika
 *
 * @author m@sote.pl
 * @version $Id: logout.inc.php,v 2.15 2006/01/20 11:21:04 lechu Exp $
* @package    users
 */

class Logout {
    /**
     * Wyrejestruj calkowicie uzytkownika.
     */
    function logout_all() {
        global $sess;
		global $shop;
        $sess->unregister("form");
        $sess->unregister("form_cor");
        $sess->unregister("form_cor_addr");
        $sess->unregister("global_prv_key");
        $sess->unregister("global_login");
        $sess->unregister("global_lock_bakset");
        $sess->unregister("global_lock_register");
        $sess->unregister("global_lock_user");
        $sess->unregister("global_firm_login");
        $sess->unregister("id_partner");
        $sess->unregister("global_id_user");
        $sess->unregister("__id_discounts_groups");
        $sess->unregister("__user_discount");
        $sess->unregister("__id_sales");
//        $sess->unregister("global_basket_data");
        $sess->unregister("global_wishlist_data");
    	// start basket & wishlist ->init
		// szuflujemy obecnymi katalogiami zeby lokalne includy koszyka byly dostepne dla skryptow
		$old_dir=getcwd();
		global $DOCUMENT_ROOT;
		$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
		chdir($path_to_basket);
		require_once("./include/my_ext_basket.inc.php");
//		$basket=& new My_Ext_Basket();
		$wishlist=& new My_Ext_Basket('wishlist');
		$wishlist->init();
//		$basket->init();
//		$basket->_key="";
		$wishlist->_key="";
		chdir($old_dir);
//		$basket->register();
		$wishlist->register();
		if (@$_SESSION['global_basket_data']['mode']=='points') {
			$sess->unregister('global_basket_data');
			$sess->unregister('global_basket_count');
		}
		$shop->basket();
		$shop->basket->reload();
    	// end basket & wishlist ->init
        return(0);
    } // end logout
 
    /**
     * Wyrejestruj dane zwiazane z zalogowanym uzytkwonikiem
     */
    function logout_user() {
        global $sess;
		global $shop;
        $sess->unregister("form");
        $sess->unregister("form_cor");
        $sess->unregister("form_cor_addr");
        $sess->unregister("global_prv_key");
        $sess->unregister("global_login");
        $sess->unregister("global_firm_login");
        $sess->unregister("global_id_user");
        $sess->unregister("__id_discounts_groups");
        $sess->unregister("__user_discount");
        $sess->unregister("__id_sales");
//        $sess->unregister("global_basket_data");
        $sess->unregister("global_wishlist_data");
    	// start basket & wishlist ->init
		// szuflujemy obecnymi katalogiami zeby lokalne includy koszyka byly dostepne dla skryptow
		$old_dir=getcwd();
		global $DOCUMENT_ROOT;
		$path_to_basket=$DOCUMENT_ROOT."/go/_basket/";
		chdir($path_to_basket);
		require_once("./include/my_ext_basket.inc.php");
//		$basket=& new My_Ext_Basket();
		$wishlist=& new My_Ext_Basket('wishlist');
		$wishlist->init();
		if (@$_SESSION['global_basket_data']['mode']=='points') {
			$sess->unregister('global_basket_data');
			$sess->unregister('global_basket_count');
		}
//		$basket->init();
//		$basket->_key="";
		$wishlist->_key="";
		chdir($old_dir);
//		$basket->register();
		$wishlist->register();
		$shop->basket();
		$shop->basket->reload();
    	// end basket & wishlist ->init
        return(0);
    } // end logout_user
} // end class Logout

$logout = new Logout;

?>