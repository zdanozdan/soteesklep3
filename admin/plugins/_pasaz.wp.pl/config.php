<?php
/**
 * Konfigruacja modu³u wp pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: config.php,v 1.6 2005/01/20 15:00:04 maroslaw Exp $
* @package    pasaz.wp.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once("./include/gen_wp_config.inc.php");
require_once("./include/wp_get_cat.inc.php");
require_once("include/metabase.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->wp_bar['config']);



if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();
if (! empty($_REQUEST['category'])) {
    $category=$_REQUEST['category'];
} else $category=array();

$item['confirm_trans']=ereg_replace("http://[a-z0-9.]+/","",@$item['confirm_trans']);

if (! empty($item['save'])) {
    $ftp->connect();    
    $gen_config->gen(array(
                           "wp_shop_id"=>$item['id'],
                           "wp_mode"=>$item['mode'],
                           "wp_login"=>$item['login'],
                           "wp_password"=>$item['password'],
                           "wp_server"=>$item['server'],
                           "wp_rpc"=>$item['rpc'],
                           "wp_message"=>$item['message'],
                           "wp_port"=>$item['port'],
                           "wp_transaction"=>$item['transaction'],
                           "wp_confirm_trans"=>$item['confirm_trans'],
                           "wp_test_server"=>$item['test_server'],
                           "wp_load"=>$item['load'],
                           "wp_category"=>$category,
                           "wp_partner_name"=>$item['partner_name'],
                           )
                     );
    $ftp->close();
    $wp_config->wp_shop_id=$item['id'];
    $wp_config->wp_mode=$item['mode'];
    $wp_config->wp_login=$item['login'];
    $wp_config->wp_password=$item['password'];
    $wp_config->wp_server=$item['server'];
    $wp_config->wp_rpc=$item['rpc'];
    $wp_config->wp_message=$item['message'];
    $wp_config->wp_port=$item['port'];
    $wp_config->wp_transaction=$item['transaction'];
    $wp_config->wp_confirm_trans=$item['confirm_trans'];
    $wp_config->wp_test_server=$item['test_server'];
    $wp_config->wp_load=$item['load'];
    $wp_config->wp_category=$category;
    $wp_config->wp_partner_name=$item['partner_name'];
    $wp_cat= new WpGetCat;
    $wp_cat->_wp_select_category();
}

require_once ("./html/wp_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
