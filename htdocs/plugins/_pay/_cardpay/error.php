<?php
/**
* Powrót po rezygnacji z p³atno¶ci przelewy24.pl
*
* @author m@sote.pl
* @version $Id: error.php,v 1.1 2005/10/26 12:45:26 lukasz Exp $
* @package przelewy24
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
@include_once ("config/auto_config/przelewy24_config.inc.php");
@include_once ("plugins/_pay/_przelewy24/lang/_$config->base_lang/lang.inc.php");
@include_once ("plugins/_pay/_przelewy24/lang/_$config->lang/lang.inc.php");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

$theme->bar($lang->przelewy24_title);
include_once ("plugins/_pay/_przelewy24/html/przelewy24_error.html.php");

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
