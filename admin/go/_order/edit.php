<?php
/**
* Edycja transakcji.
*
* @author  m@sote.pl
* @version $Id: edit.php,v 2.18 2005/12/14 08:52:12 lechu Exp $
* @package    order
*/

/**
* \@global $id GET (lub $order_id)
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

// inicjuj ID
if (! empty($_REQUEST['order_id'])) {
    $order_id=addslashes($_REQUEST['order_id']);
    if (! ereg("^[0-9]+$",$order_id)) $order_id=0; 
    else {
        $order_id=$mdbd->select("order_id","order_register","order_id=?",array($order_id=>"int"),"LIMIT 1");
    }
}

$theme->head_window();

if (empty($order_id)) {
    print "<center>";
    print $lang->order_errors['unknown_order'];
    $theme->close();
    print "</center>";
    $theme->foot_window();       
    exit;
}

require_once ("include/currency.inc.php");
require_once ("include/my_crypt.inc");
require_once ("./include/order_func.inc.php");
require_once ("./include/order_products.inc.php");
require_once ("./include/get_order_id.inc.php");
require_once ("config/auto_config/points_config.inc.php");

// jesli punkty naliczane sa za wartosc punktowa produktow to 
// zablokuj edycje transakcji
if($config_points->for_type == 2) {
    $order_print=1;
}

$order_products =& new orderProducts($order_id);

// wywolano aktualizacje transakcji
if (@$_POST['update']==true) {
    
    // usuñ zaznaczone produkty z zamówienia
    if (! empty($_REQUEST['products_del'])) {
        // @todo dodac funkcjê usuwaj±ca odpowiednie rekordy z order_products + wywo³anie
        $order_products->delete($_REQUEST['products_del']);        
    }
    
    // aktualizuj dane zamówienia (dodanie nowego produktu do zamówienia)    
    if (! empty($_REQUEST['products_add']['user_id'])) {        
        $order_products->add($_REQUEST['products_add']);    
    }    

    // kwota zamówienia wg. tabeli order_products
    $__total_amount=$order_products->totalAmount($order_id);   
    
    // aktualizuj pozosta³e dane zamówienia
    include_once ("./include/order_update.inc.php");
}
/**
* Odczytaj dane transakcji.
*/
require_once("./include/select.inc.php");
$theme->head_window();

echo "<a href='/go/_order/print.php?order_id=$order_id'><img src='"; $theme->img("_img/druk.gif"); echo "' border=0></a>";
include_once ("./include/menu_edit.inc.php");
$theme->bar($lang->bar_title["order_edit"]." ".$rec->data['order_id']);
/**
* Wy¶wietl formularz edycji statusu transakcji.
*/

include_once ("./html/edit.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>
