<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu allegro
 *
 * @author  rdiak@sote.pl
 * @version $Id: category1.php,v 1.4 2006/04/12 11:45:26 scalak Exp $
 * @package allegro.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head_stream.inc.php");
require_once ("../../include/allegro.inc.php");
require_once("./include/gen_allegro_config.inc.php");
include_once("config/auto_config/allegro_config.inc.php");


// naglowek
$theme->head_window();
$theme->bar($lang->allegro_bar['cat']);


print "<br><center>".$lang->allegro_get_cat['timeout']."<br></center>";
flush();

$allegro=new Allegro;
if(@$_REQUEST['get_param'] == 'GetTree') {
    $allegro->getCategory();
} elseif(@$_REQUEST['get_param'] == 'GetOther') {
    $allegro->getOther();
    $ftp->connect();
    $gen_config->gen(array(
                           "allegro_login"=>$allegro_config->allegro_login,
                           "allegro_login_test"=>$allegro_config->allegro_login_test,
                           "allegro_password"=>$allegro_config->allegro_password,
                           "allegro_password_test"=>$allegro_config->allegro_password_test,
                           "allegro_web_api_key"=>$allegro_config->allegro_web_api_key,
                           "allegro_country_code"=>$allegro_config->allegro_country_code,
                           "allegro_country_code_test"=>$allegro_config->allegro_country_code_test,
                           "allegro_category"=>$allegro_config->allegro_category,
                           "allegro_server"=>$allegro_config->allegro_server,
                           "allegro_version"=>$allegro_config->allegro_version,
                           "allegro_version_test"=>$allegro_config->allegro_version_test,
                           "allegro_time"=>$allegro->allegro_time,
                           "allegro_states"=>$allegro->allegro_states,
                           "allegro_trans"=>$allegro->allegro_trans,
                           "allegro_city"=>$allegro_config->allegro_city,
                           "allegro_state_select"=>$allegro_config->allegro_state_select,
                           "allegro_mode"=>$allegro_config->allegro_mode,
                   )
    );
    $ftp->close();
} else {
    print "<center><font color=red>Nie wybrano ¿adnej opcji</font></center>";
}

include_once ("./html/allegro_close.html.php");

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
