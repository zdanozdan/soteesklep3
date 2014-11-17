<?php
/**
 * Dodanie tematu
 *
 * @author     lech@sote.pl
 * @version    $Id: action_add_delete.php,v 1.6 2005/03/15 10:28:58 lechu Exp $
 * @package    admin
 * @subpackage _themes 
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");
require_once("include/gen_user_config.inc.php");

$new_theme_name = @$_REQUEST['new_theme_name'];

$theme->head_window();

if($_REQUEST['action'] == 'add') {
    $new_theme_default = @$_REQUEST['new_theme_default'];
    
    if($new_theme_default == 1)
        $new_theme_defaulf_checked = 'checked';
    $message = '';
    if(!empty($new_theme_name)) {
        if(eregi("^[0-9a-z_-]+$",$new_theme_name)) {
            if(empty($config->themes[$new_theme_name])) {
                // add theme here
                $config->themes[$new_theme_name] = $new_theme_name;
                $config->themes_active[$new_theme_name] = 'on';
                $ftp->connect();
                if (!is_dir("$DOCUMENT_ROOT/../htdocs/themes/base/" . $new_theme_name)) {
                    $ftp->mkdir($config->ftp_dir . "/htdocs/themes/base/" . $new_theme_name);
                }
                else
                    $message .= $lang->themes_folder_exists . " ";
                $gen_config->gen( array("themes"=>$config->themes) );
                $gen_config->gen( array("themes_active"=>$config->themes_active) );
                if($new_theme_default == 1)
                    $gen_config->gen( array("theme"=>$new_theme_name) );
                $ftp->close();
                $message .= $lang->themes_added . '<br>
                '. "<b>/htdocs/themes/base/" . $new_theme_name . "</b>.<br>
                <script> window.opener.history.go(0); </script>";
            }
            else
                $message .= "<span style='color: red;'>" . $lang->themes_exists . "</span>";
        }
        else
            $message = "<span style='color: red;'>" . $lang->themes_invalid . "</span>";
    }
    
    $theme->bar($lang->themes_addition);
    echo "$message";
    include_once("./html/action_add.html.php");
}
if($_REQUEST['action'] == 'delete') {
    if(empty($_REQUEST['confirm'])) {
        $theme->bar($lang->themes_deletion);
        include_once("./html/action_delete.html.php");
    }
    else {
        unset($config->themes[$new_theme_name]);
        unset($config->themes_active[$new_theme_name]);
        $ftp->connect();
        $gen_config->gen( array("themes"=>$config->themes) );
        $gen_config->gen( array("themes_active"=>$config->themes_active) );
        $ftp->close();
        echo "
        <script>
            window.opener.history.go(0);
            window.close();
        </script>
        ";
    }
}
$theme->foot_window();
include_once ("include/foot.inc");

?>