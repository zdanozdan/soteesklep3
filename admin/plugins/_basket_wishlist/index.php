<?php
/**
 * Modu³ konfiguracji koszyka i przechowalni
 * 
 * @author lech@sote.pl
 * @version $Id: index.php,v 1.2 2005/12/09 14:28:44 lechu Exp $
* @package    _basket_wishlist
 */

// naglowek php
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");


$theme->head();
$theme->page_open_head();
include_once("./include/menu.inc.php");
$theme->bar($lang->bar_main);



if(@$_REQUEST['action'] == 'conf01') {
	include_once("./include/conf01.inc.php");
	echo "<br><br>" . $lang->conf01_info_ok . ".<br><br>";
}


/**/

// $assoc_rules->_displayRules();
include_once("./html/conf01.html.php");
$theme->page_open_foot();
$theme->foot();
include_once ("include/foot.inc");
?>