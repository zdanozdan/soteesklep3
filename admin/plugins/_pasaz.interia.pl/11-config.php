<?php
/**
 * Konfigruacja modu³u interia pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: config.php,v 1.3 2005/12/23 14:37:21 scalak Exp $
* @package    pasaz.interia.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
@include_once ("config/auto_config/interia_config.inc.php");
require_once("./include/gen_interia_config.inc.php");
require_once("./include/interia_get_cat.inc.php");
require_once("include/metabase.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->interia_bar['config']);



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
                           "interia_shop_id"=>$item['id'],
                           "interia_password"=>$item['password'],
                           "interia_server"=>$item['server'],
                           "interia_rpc"=>$item['rpc'],
                           "interia_message"=>$item['message'],
                           "interia_port"=>$item['port'],
                           "interia_transaction"=>$item['transaction'],
                           "interia_test_server"=>$item['test_server'],
                           "interia_category"=>$category,
                           "interia_partner_name"=>$item['partner_name'],
                           "interia_load"=>$item['load'],
                           )
                     );
    $ftp->close();
    $interia_config->interia_shop_id=$item['id'];
    $interia_config->interia_password=$item['password'];
    $interia_config->interia_server=$item['server'];
    $interia_config->interia_rpc=$item['rpc'];
    $interia_config->interia_message=$item['message'];
    $interia_config->interia_port=$item['port'];
    $interia_config->interia_transaction=$item['transaction'];
    $interia_config->interia_test_server=$item['test_server'];
    $interia_config->interia_category=$category;
    $interia_config->interia_partner_name=$item['partner_name'];
    $interia_config->interia_load=$item['load'];
    
    InteriaGetCat::interia_select_cut();
}

require_once ("./html/interia_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
