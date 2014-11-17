<?php
/**
* Edycja transakcji.
*
* @author  m@sote.pl
* @version $Id: print.php,v 1.2 2006/05/08 10:10:11 lechu Exp $
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
$order_print = true;
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

$order_products =& new orderProducts($order_id);


/**
* Odczytaj dane transakcji.
*/
require_once("./include/select.inc.php");
$theme->head_window();

// include_once ("./include/menu_edit.inc.php");
//$theme->bar($lang->bar_title["order_edit"]." ".$rec->data['order_id']);


// zawiñ opis do 50 znaków, je¶li jest taka potrzeba
$max_line_length = 50;

if(!empty($rec->data['description'])) {
    $desc_arr = explode(' ', $rec->data['description']);
    $desc_arr_out = array();
    reset($desc_arr);
    while (list($key, $val) = each($desc_arr)) {
    	if (strlen($val) > $max_line_length) {
    	    $val = wordwrap($val, $max_line_length, "<br />", 1);
    	}
    	$desc_arr_out[$key] = $val;
    }
    $rec->data['description'] = implode(' ', $desc_arr_out);
}

/**
* Wy¶wietl formularz edycji statusu transakcji.
*/
include_once ("./html/print.html.php");

$theme->foot_window();
include_once ("include/foot.inc");
?>
