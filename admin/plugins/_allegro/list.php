<?php
/**
 * Strona g³ówna modu³u Allegro 
 *
 * @author  r@sote.pl
 * @version $Id: list.php,v 1.2 2006/04/12 12:54:27 scalak Exp $
*  @package allegro    
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../include/head.inc");
require_once ("../../include/allegro.inc.php");

$theme->head();
$theme->page_open_head();

print "<form action=delete.php method=post name=FormList>";
include_once ("./include/menu.inc.php");
$theme->bar($lang->allegro_bar["list"]);

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/allegro_row_list.inc.php");
$dbedit = new DBEditList;
$sql="SELECT * FROM allegro_auctions WHERE allegro_number!=''";
$dbedit->top_links="false";
$dbedit->record_class="AllegroRowList";
print "<p>";

include_once ("./include/list_th1.inc.php");
$dbedit->start_list_element=allegro_list_th1();

$dbedit->show();

$theme->page_open_foot();
print "</form>";


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
