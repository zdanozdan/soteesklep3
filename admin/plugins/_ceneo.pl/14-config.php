<?php
/**
 * Konfiguracja modu³u z ceneo
 *
 * @author  rdiak@sote.pl
 * @version $Id: config.php,v 1.1 2006/01/06 13:05:04 scalak Exp $
* @package    pasaz.ceneo.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu oraz inne potrzebne pliki
 */
require_once ("../../../include/head.inc");
@include_once ("config/auto_config/ceneo_config.inc.php");
require_once("./include/gen_ceneo_config.inc.php");
require_once("include/metabase.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->ceneo_bar['config']);



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
                           "ceneo_shop_id"=>$item['id'],
                           "ceneo_load"=>$item['load'],
                           "ceneo_login"=>$item['login'],
                           "ceneo_password"=>$item['password'],
                           "ceneo_server"=>$item['server'],
                           "ceneo_message"=>$item['message'],
                           "ceneo_port"=>$item['port'],
                           "ceneo_test_server"=>$item['test_server'],
                           "ceneo_category"=>$category,
                           "ceneo_partner_name"=>$item['partner_name'],
                           )
                     );
    $ftp->close();
    $ceneo_config->ceneo_shop_id=$item['id'];
    $ceneo_config->ceneo_load=$item['load'];
    $ceneo_config->ceneo_login=$item['login'];
    $ceneo_config->ceneo_password=$item['password'];
    $ceneo_config->ceneo_server=$item['server'];
    $ceneo_config->ceneo_message=$item['message'];
    $ceneo_config->ceneo_port=$item['port'];
    $ceneo_config->ceneo_test_server=$item['test_server'];
    $ceneo_config->ceneo_category=$category;
    $ceneo_config->ceneo_partner_name=$item['partner_name'];
}

require_once ("./html/ceneo_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
