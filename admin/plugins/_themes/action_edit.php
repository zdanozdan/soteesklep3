<?php
/**
 * Edycja wygl±du wybranego tematu
 *
 * @author     amiklosz@sote.pl lech@sote.pl
 * @version    $Id: action_edit.php,v 1.5 2005/01/20 15:00:10 maroslaw Exp $
* @package    themes
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

require_once ("../../../include/head.inc");

$popup = @$_REQUEST['popup'];
$thm = @$_REQUEST['thm'];
if($popup == 1){
    $theme->head_window();
    include_once("./html/edit_element.html.php");
    $theme->foot_window();
}
else{
    $theme->head();
    $theme->page_open_head();
    require_once("./include/submenu.inc.php");
    include_once("./html/themes/$thm/index.php");
    $theme->page_open_foot();
    $theme->foot();
}

include_once ("include/foot.inc");


?>
