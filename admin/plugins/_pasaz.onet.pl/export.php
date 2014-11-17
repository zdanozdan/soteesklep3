<?php
/**
 * Export produktów do onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: export.php,v 1.9 2005/01/20 15:00:03 maroslaw Exp $
* @package    pasaz.onet.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->onet_bar['export']);
require_once ("include/save_auth_session.inc.php");

print "<br>";
print $lang->onet_export['info'];
print "<br><br>";

$__disable_trash='false';
// zaznacz wszystkie produkty
$sql = "SELECT * FROM main WHERE onet_export=1";

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

$dbedit = new DBEditList;
$dbedit->start_list_element=$theme->list_th();

$dbedit->show();

include_once ("./html/onet_export.html.php");    

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
