<?php
/**
* Przejscie na strone aytoryzacji Inteligo
*
* @author m@sote.pl
* @version $Id: error.php,v 1.5 2005/01/20 15:00:29 maroslaw Exp $
* @package    pay
* @subpackage inteligo
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("go/_basket/include/my_basket.inc.php");
@include_once ("config/auto_config/config_inteligo.inc.php");
include ("./include/inteligo.inc.php");

$theme->head();
$theme->page_open_head("page_open_1_head");

if (in_array("inteligo",$config->plugins)) {
    $inteligo=new Inteligo;
    $theme->theme_file("_inteligo/inteligo_false.html.php");
}

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
