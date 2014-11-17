<?php
/**
 * Pobieranie kategorii z onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: category.php,v 1.6 2005/01/20 15:00:02 maroslaw Exp $
* @package    pasaz.onet.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../include/head.inc");

$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->onet_bar['cat']);
require_once ("include/save_auth_session.inc.php");

include_once ("./html/onet_category.html.php");    

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
