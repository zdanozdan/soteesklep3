<?php
/**
 * Konfiguracja modu³u allegro
 *
 * @author  krzys@sote.pl
 * @version $Id: config.php,v 1.6 2006/04/12 11:45:27 scalak Exp $
* @package    allegro
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu oraz inne potrzebne pliki
 */
require_once ("../../../include/head.inc");
@include_once ("config/auto_config/allegro_config.inc.php");
require_once("./include/gen_allegro_config.inc.php");
require_once("include/metabase.inc");
require_once("include/allegro.inc.php");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->allegro_bar['config']);

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item=array();
if (! empty($_REQUEST['category'])) {
    $category=$_REQUEST['category'];
} else $category=array();


if (! empty($item['save'])) {
    $ftp->connect();    
    $gen_config->gen(array(
                           "allegro_login"=>$item['login'],
                           "allegro_login_test"=>$item['login_test'],
                           "allegro_password"=>$item['password'],
                           "allegro_password_test"=>$item['password_test'],
                           "allegro_web_api_key"=>$item['web_api_key'],
                           "allegro_country_code"=>$item['country_code'],
                           "allegro_country_code_test"=>$item['country_code_test'],
                           "allegro_category"=>$category,
                           "allegro_category_test"=>$category_test,
                           "allegro_server"=>$item['server'],
                           "allegro_version"=>$item['version'],
                           "allegro_version_test"=>$item['version_test'],
                           "allegro_time"=>$allegro_config->allegro_time,
                           "allegro_trans"=>$allegro_config->allegro_trans,
                           "allegro_states"=>$allegro_config->allegro_states,
                           "allegro_mode"=>$item['mode'],
                           "allegro_city"=>$item['city'],
                           "allegro_state_select"=>$item['state_select']
                           )
                     );
    $ftp->close();
    $allegro_config->allegro_login=$item['login'];
    $allegro_config->allegro_login_test=$item['login_test'];
    $allegro_config->allegro_password=$item['password'];
    $allegro_config->allegro_password_test=$item['password_test'];
    $allegro_config->allegro_web_api_key=$item['web_api_key'];
    $allegro_config->allegro_country_code=$item['country_code'];
    $allegro_config->allegro_country_code_test=$item['country_code_test'];
    $allegro_config->allegro_category=$category;
    $allegro_config->allegro_category_test=$category_test;
    $allegro_config->allegro_server=$item['server'];
    $allegro_config->allegro_version=$item['version'];
    $allegro_config->allegro_version_test=$item['version_test'];
    $allegro_config->allegro_mode=$item['mode'];
    $allegro_config->allegro_city=$item['city'];
    $allegro_config->allegro_state_select=$item['state_select'];
}
$allegro=new Allegro;
$allegro->Login();

require_once ("./html/allegro_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
