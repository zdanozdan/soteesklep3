<?php
/**
* Edycja parametrów produktu wymaganych do exportu do pasaz.ceneo.pl
*
* @author  krzys@sote.pl
* @version $Id: edit_ceneo.php,v 2.2 2006/08/16 10:20:55 lukasz Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

$global_database=true;
$global_secure_test=true;

if (empty($DOCUMENT_ROOT)) {
	$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

if (! empty($_REQUEST['id'])) {
	$id=$_REQUEST['id'];
}

require_once ("include/metabase.inc");
include_once ("config/auto_config/ceneo_config.inc.php");


if (! empty($_REQUEST['update'])) {
		require_once ("./include/edit_update_ceneo.inc.php");
	}
include ("include/query_rec_ceneo.inc.php");

$theme->head_window();
// menu
include_once ("./include/menu.inc.php");
require_once("./html/edit_ceneo.html.php");
			



$theme->foot_window();
include_once ("include/foot.inc");
?>
