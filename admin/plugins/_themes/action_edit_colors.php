<?php
/**
* Edycja kolorów wybranego tematu
*
* @author     lech@sote.pl
* @version    $Id: action_edit_colors.php,v 1.4 2005/01/20 15:00:10 maroslaw Exp $
* @package    themes

*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

require_once ("../../../include/head.inc");

$popup = @$_REQUEST['popup'];
$thm = @$_REQUEST['thm'];
include_once("./html/themes/config/config.inc.php");

if(@$_REQUEST['color_update'] == 1) {
    $config->theme_config['colors'][$_REQUEST['color_name']] = $_REQUEST['color_value'];
    require_once("include/php.inc.php");
    require_once ("include/ftp.inc.php");

    $php =& new PHPFile;
    $x= $php->genPHPFileValues('config', array('theme_config'=> $config->theme_config));
    $dirname = $config->ftp['ftp_dir'] . "/admin/plugins/_themes/html/themes/$thm/config/";
    // end
    $filename = "user_config.inc.php";
    $local = $DOCUMENT_ROOT . '/tmp/' . $filename;
    if (!$handle = fopen($local, 'w')) {
        echo "Nie mo¿na utworzyæ pliku ($local)";
        exit;
    }

    if (fwrite($handle, $x) === FALSE) {
        // @todo komunikaty tylko w lang !!!
        echo "Nie mo¿na pisaæ do pliku ($local)";
        exit;
    }
    fclose($handle);

    //        echo "[$local, $dirname, $fileentry]";
    $ftp->connect();
    $ftp->put($local, $dirname, $filename);
    $ftp->close();
    unlink($local);
}

$theme->head();
$theme->page_open_head();
require_once("./include/submenu.inc.php");
$theme->bar("$lang->themes_color_bar $thm");
include_once("./html/edit_colors.html.php");
$theme->page_open_foot();
$theme->foot();

include_once ("include/foot.inc");


?>
