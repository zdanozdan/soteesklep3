<?php
/**
 * Konfiguracja modu³u z onet
 *
 * @author  rdiak@sote.pl
 * @version $Id: config.php,v 1.18 2005/01/20 15:00:03 maroslaw Exp $
* @package    pasaz.onet.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu oraz inne potrzebne pliki
 */
require_once ("../../../include/head.inc");
@include_once ("config/auto_config/onet_config.inc.php");
require_once("./include/gen_onet_config.inc.php");
require_once("./include/onet_get_cat.inc.php");
require_once("include/metabase.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->onet_bar['config']);



if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();
if (! empty($_REQUEST['category'])) {
    $category=$_REQUEST['category'];
} else $category=array();

$item['confirm_trans']=ereg_replace("http://[a-z0-9._]+/","",@$item['confirm_trans']);

if (! empty($item['save'])) {
    $ftp->connect();    
    $gen_config->gen(array(
                           "onet_shop_id"=>$item['id'],
                           "onet_mode"=>$item['mode'],
                           "onet_login"=>$item['login'],
                           "onet_password"=>$item['password'],
                           "onet_server"=>$item['server'],
                           "onet_rpc"=>$item['rpc'],
                           "onet_message"=>$item['message'],
                           "onet_port"=>$item['port'],
                           "onet_transaction"=>$item['transaction'],
                           "onet_confirm_trans"=>$item['confirm_trans'],
                           "onet_test_server"=>$item['test_server'],
                           "onet_load"=>$item['load'],
                           "onet_category"=>$category,
                           "onet_partner_name"=>$item['partner_name'],
                           )
                     );
    $ftp->close();
    $onet_config->onet_shop_id=$item['id'];
    $onet_config->onet_mode=$item['mode'];
    $onet_config->onet_login=$item['login'];
    $onet_config->onet_password=$item['password'];
    $onet_config->onet_server=$item['server'];
    $onet_config->onet_rpc=$item['rpc'];
    $onet_config->onet_message=$item['message'];
    $onet_config->onet_port=$item['port'];
    $onet_config->onet_transaction=$item['transaction'];
    $onet_config->onet_confirm_trans=$item['confirm_trans'];
    $onet_config->onet_test_server=$item['test_server'];
    $onet_config->onet_load=$item['load'];
    $onet_config->onet_category=$category;
    $onet_config->onet_partner_name=$item['partner_name'];
    $onet_get_cat= new OnetGetCat();
    $onet_get_cat->onet_select();
}

require_once ("./html/onet_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
